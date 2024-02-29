<?php

namespace App\Http\Controllers\PDF;

use App\Http\Controllers\Controller;
use App\Models\BayanihanLeader;
use App\Models\bayanihanMember;
use App\Models\POE;
use App\Models\ProgramOutcome;
use App\Models\Syllabus;
use App\Models\SyllabusCoPo;
use App\Models\SyllabusCotCoF;
use App\Models\SyllabusCotCoM;
use App\Models\SyllabusCourseOutcome;
use App\Models\SyllabusCourseOutlineMidterm;
use App\Models\SyllabusCourseOutlinesFinal;
use App\Models\SyllabusDeanFeedback;
use App\Models\SyllabusInstructor;
use App\Models\SyllabusReviewForm;
use App\Models\Tos;
use App\Models\TosRows;
use GuzzleHttp\Psr7\Response;
use PhpOffice\PhpWord\PhpWord;

class PDFController extends Controller
{
    public function pdf2($tos_id)
    {
        $tos = Tos::where('tos_id', $tos_id)->join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'tos.bg_id')
            ->join('courses', 'courses.course_id', '=', 'tos.course_id')
            ->join('syllabi', 'syllabi.syll_id', '=', 'tos.syll_id')
            ->select('tos.*', 'bayanihan_groups.*', 'courses.*')->first();
        $course_outcomes = SyllabusCourseOutcome::where('syll_id', '=', $tos->syll_id)->select('syllabus_course_outcomes.*')->get();
        $tos_rows = TosRows::where('tos_rows.tos_id', '=', $tos_id)
            ->leftJoin('tos', 'tos.tos_id', '=', 'tos_rows.tos_id')
            ->select('tos.*', 'tos_rows.*')
            ->get();
        $bLeaders = BayanihanLeader::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_leaders.bg_id')
            ->join('tos', 'tos.bg_id', '=', 'bayanihan_groups.bg_id')
            ->join('users', 'users.id', '=', 'bayanihan_leaders.bg_user_id')
            ->select('bayanihan_leaders.*', 'users.*')
            ->where('tos.tos_id', '=', $tos_id)
            ->get();

        $bMembers = BayanihanMember::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_members.bg_id')
            ->join('tos', 'tos.bg_id', '=', 'bayanihan_members.bg_id')
            ->join('users', 'users.id', '=', 'bayanihan_members.bm_user_id')
            ->select('bayanihan_members.*', 'users.*')
            ->where('tos.tos_id', '=', $tos_id)
            ->get();
        $tosVersions = Tos::where('tos.bg_id', $tos->bg_id)
            ->select('tos.*')
            ->get();

        $chair = Syllabus::join('tos', 'tos.syll_id', '=', 'syllabi.syll_id')
            ->join('chairpeople', 'syllabi.department_id', '=', 'chairpeople.department_id')
            ->join('users', 'users.id', '=', 'chairpeople.user_id')
            ->first();
        return view('PDF.tosPDF', compact('tos_rows', 'tos', 'tos_id', 'bMembers', 'bLeaders', 'tosVersions', 'course_outcomes', 'chair'));
    }
    public function pdf($syll_id)
    {
        $syll = Syllabus::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'syllabi.bg_id')
            ->join('colleges', 'colleges.college_id', '=', 'syllabi.college_id')
            ->join('departments', 'departments.department_id', '=', 'syllabi.department_id') // Corrected
            ->join('curricula', 'curricula.curr_id', '=', 'syllabi.curr_id')
            ->join('courses', 'courses.course_id', '=', 'syllabi.course_id')
            ->where('syllabi.syll_id', '=', $syll_id)
            ->select('courses.*', 'bayanihan_groups.*', 'syllabi.*', 'departments.*', 'curricula.*', 'colleges.college_description', 'colleges.college_code')
            ->first();

        $programOutcomes = ProgramOutcome::join('departments', 'departments.department_id', '=', 'program_outcomes.department_id')
            ->join('syllabi', 'syllabi.department_id', '=', 'departments.department_id')
            ->where('syllabi.syll_id', '=', $syll_id)
            ->select('program_outcomes.*')
            ->get();
        $poes = POE::join('departments', 'departments.department_id', '=', 'poes.department_id')
            ->join('syllabi', 'syllabi.department_id', '=', 'departments.department_id')
            ->where('syllabi.syll_id', '=', $syll_id)
            ->select('poes.*')
            ->get();

        $courseOutcomes = SyllabusCourseOutcome::where('syll_id', '=', $syll_id)
            ->get();

        // foreach ($courseOutcomes as $courseOutcome) {
        //     $copos = SyllabusCoPO::where('syll_co_id', '=', $courseOutcome->syll_co_id)
        //         ->get();
        // }
        $copos = SyllabusCoPO::where('syll_id', '=', $syll_id)
            ->get();

        $instructors = SyllabusInstructor::join('users', 'syllabus_instructors.syll_ins_user_id', '=', 'users.id')
            ->select('users.*', 'syllabus_instructors.*')
            ->get()
            ->groupBy('syll_id');

        $courseOutlines = SyllabusCourseOutlineMidterm::where('syll_id', '=', $syll_id)
            ->with('courseOutcomes')
            ->orderBy('syll_row_no', 'asc')
            ->get();

        $courseOutlinesFinals = SyllabusCourseOutlinesFinal::where('syll_id', '=', $syll_id)
            ->with('courseOutcomes')
            ->orderBy('syll_row_no', 'asc')
            ->get();

        $cotCos = SyllabusCotCoM::join('syllabus_course_outcomes', 'syllabus_cot_cos_midterms.syll_co_id', '=', 'syllabus_course_outcomes.syll_co_id')
            ->select('syllabus_course_outcomes.*', 'syllabus_cot_cos_midterms.*')
            ->get()
            ->groupBy('syll_co_out_id');

        $cotCosF = SyllabusCotCoF::join('syllabus_course_outcomes', 'syllabus_cot_cos_finals.syll_co_id', '=', 'syllabus_course_outcomes.syll_co_id')
            ->select('syllabus_course_outcomes.*', 'syllabus_cot_cos_finals.*')
            ->get()
            ->groupBy('syll_co_out_id');

        $bLeaders = BayanihanLeader::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_leaders.bg_id')
            ->join('syllabi', 'syllabi.bg_id', '=', 'bayanihan_groups.bg_id')
            ->join('users', 'users.id', '=', 'bayanihan_leaders.bg_user_id')
            ->select('bayanihan_leaders.*', 'users.*')
            ->where('syllabi.syll_id', '=', $syll_id)
            ->get();

        $bMembers = bayanihanMember::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_members.bg_id')
            ->join('syllabi', 'syllabi.bg_id', '=', 'bayanihan_members.bg_id')
            ->join('users', 'users.id', '=', 'bayanihan_members.bm_user_id')
            ->select('bayanihan_members.*', 'users.*')
            ->where('syllabi.syll_id', '=', $syll_id)
            ->get();
        // $syllabusComments = SyllabusComment::join('users', 'users.id', '=', 'syllabus_comments.user_id')
        // ->where('syllabus_comments.syll_id', '=', $syll_id)
        // ->select('users.*', 'syllabus_comments.*')
        // ->orderBy('syllabus_comments.syll_created_at', 'asc')
        // ->get();

        $reviewForm = SyllabusReviewForm::join('srf_checklists', 'srf_checklists.srf_id', '=', 'syllabus_review_forms.srf_id')
            ->where('syllabus_review_forms.syll_id', $syll_id)
            ->select('srf_checklists.*', 'syllabus_review_forms.*')
            ->first();

        $syllabusVersions = Syllabus::where('syllabi.bg_id', $syll->bg_id)
            ->select('syllabi.*')
            ->get();
        $feedback = SyllabusDeanFeedback::where('syll_id', $syll_id)->first();

        return view('pdf.syllabusPDF', compact(
            'syll',
            'instructors',
            'syll_id',
            'instructors',
            'courseOutcomes',
            'programOutcomes',
            'copos',
            'courseOutlines',
            'cotCos',
            'courseOutlinesFinals',
            'cotCosF',
            'bLeaders',
            'bMembers',
            'poes',
            'reviewForm',
            'syllabusVersions',
            'feedback'
        ))->with('success', 'Switched to Edit Mode');
    }
    // public function generateTOSPDF($tos_id)
    // {
    //     $tos = Tos::where('tos_id', $tos_id)->join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'tos.bg_id')
    //         ->join('courses', 'courses.course_id', '=', 'tos.course_id')
    //         ->join('syllabi', 'syllabi.syll_id', '=', 'tos.syll_id')
    //         ->select('tos.*', 'bayanihan_groups.*', 'courses.*')->first();
    //     $course_outcomes = SyllabusCourseOutcome::where('syll_id', '=', $tos->syll_id)->select('syllabus_course_outcomes.*')->get();
    //     $tos_rows = TosRows::where('tos_rows.tos_id', '=', $tos_id)
    //         ->leftJoin('tos', 'tos.tos_id', '=', 'tos_rows.tos_id')
    //         ->select('tos.*', 'tos_rows.*')
    //         ->get();
    //     $bLeaders = BayanihanLeader::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_leaders.bg_id')
    //         ->join('tos', 'tos.bg_id', '=', 'bayanihan_groups.bg_id')
    //         ->join('users', 'users.id', '=', 'bayanihan_leaders.bg_user_id')
    //         ->select('bayanihan_leaders.*', 'users.*')
    //         ->where('tos.tos_id', '=', $tos_id)
    //         ->get();

    //     $bMembers = BayanihanMember::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_members.bg_id')
    //         ->join('tos', 'tos.bg_id', '=', 'bayanihan_members.bg_id')
    //         ->join('users', 'users.id', '=', 'bayanihan_members.bm_user_id')
    //         ->select('bayanihan_members.*', 'users.*')
    //         ->where('tos.tos_id', '=', $tos_id)
    //         ->get();
    //     $tosVersions = Tos::where('tos.bg_id', $tos->bg_id)
    //         ->select('tos.*')
    //         ->get();

    //     $chair = Syllabus::join('tos', 'tos.syll_id', '=', 'syllabi.syll_id')
    //         ->join('chairpeople', 'syllabi.department_id', '=', 'chairpeople.department_id')
    //         ->join('users', 'users.id', '=', 'chairpeople.user_id')
    //         ->first();

    //     $data = [
    //         'title' => 'Welcome to Tutsmake.com',
    //         'date' => date('m/d/Y'),
    //         'tos' => $tos,
    //         'course_outcomes' => $course_outcomes,
    //         'tos_rows' => $tos_rows,
    //         'bLeaders' => $bLeaders,
    //         'bMembers' => $bMembers,
    //         'tosVersions' => $tosVersions,
    //         'chair' => $chair,
    //     ];
    //     $pdf = PDF::loadView('PDF.tosPDF', $data);
    //     return $pdf->download('tos.pdf');
    // }

    // public function generateSyllabusPDF($syll_id)
    // {

    //     $syll = Syllabus::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'syllabi.bg_id')
    //         ->join('colleges', 'colleges.college_id', '=', 'syllabi.college_id')
    //         ->join('departments', 'departments.department_id', '=', 'syllabi.department_id') // Corrected
    //         ->join('curricula', 'curricula.curr_id', '=', 'syllabi.curr_id')
    //         ->join('courses', 'courses.course_id', '=', 'syllabi.course_id')
    //         ->where('syllabi.syll_id', '=', $syll_id)
    //         ->select('courses.*', 'bayanihan_groups.*', 'syllabi.*', 'departments.*', 'curricula.*', 'colleges.college_description', 'colleges.college_code')
    //         ->first();

    //     $programOutcomes = ProgramOutcome::join('departments', 'departments.department_id', '=', 'program_outcomes.department_id')
    //         ->join('syllabi', 'syllabi.department_id', '=', 'departments.department_id')
    //         ->where('syllabi.syll_id', '=', $syll_id)
    //         ->select('program_outcomes.*')
    //         ->get();
    //     $poes = POE::join('departments', 'departments.department_id', '=', 'poes.department_id')
    //         ->join('syllabi', 'syllabi.department_id', '=', 'departments.department_id')
    //         ->where('syllabi.syll_id', '=', $syll_id)
    //         ->select('poes.*')
    //         ->get();

    //     $courseOutcomes = SyllabusCourseOutcome::where('syll_id', '=', $syll_id)
    //         ->get();
    //     $copos = [];
    //     foreach ($courseOutcomes as $courseOutcome) {
    //         $copos = SyllabusCoPo::where('syll_co_id', '=', $courseOutcome->syll_co_id)
    //             ->get();
    //     }
    //     $instructors = SyllabusInstructor::join('users', 'syllabus_instructors.syll_ins_user_id', '=', 'users.id')
    //         ->select('users.*', 'syllabus_instructors.*')
    //         ->get()
    //         ->groupBy('syll_id');

    //     $courseOutlines = SyllabusCourseOutlineMidterm::where('syll_id', '=', $syll_id)
    //         ->with('courseOutcomes')
    //         ->orderBy('syll_row_no', 'asc')
    //         ->get();

    //     $courseOutlinesFinals = SyllabusCourseOutlinesFinal::where('syll_id', '=', $syll_id)
    //         ->with('courseOutcomes')
    //         ->orderBy('syll_row_no', 'asc')
    //         ->get();

    //     $cotCos = SyllabusCotCoM::join('syllabus_course_outcomes', 'syllabus_cot_cos_midterms.syll_co_id', '=', 'syllabus_course_outcomes.syll_co_id')
    //         ->select('syllabus_course_outcomes.*', 'syllabus_cot_cos_midterms.*')
    //         ->get()
    //         ->groupBy('syll_co_out_id');

    //     $cotCosF = SyllabusCotCoF::join('syllabus_course_outcomes', 'syllabus_cot_cos_finals.syll_co_id', '=', 'syllabus_course_outcomes.syll_co_id')
    //         ->select('syllabus_course_outcomes.*', 'syllabus_cot_cos_finals.*')
    //         ->get()
    //         ->groupBy('syll_co_out_id');

    //     $bLeaders = BayanihanLeader::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_leaders.bg_id')
    //         ->join('syllabi', 'syllabi.bg_id', '=', 'bayanihan_groups.bg_id')
    //         ->join('users', 'users.id', '=', 'bayanihan_leaders.bg_user_id')
    //         ->select('bayanihan_leaders.*', 'users.*')
    //         ->where('syllabi.syll_id', '=', $syll_id)
    //         ->get();

    //     $bMembers = BayanihanMember::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_members.bg_id')
    //         ->join('syllabi', 'syllabi.bg_id', '=', 'bayanihan_members.bg_id')
    //         ->join('users', 'users.id', '=', 'bayanihan_members.bm_user_id')
    //         ->select('bayanihan_members.*', 'users.*')
    //         ->where('syllabi.syll_id', '=', $syll_id)
    //         ->get();

    //     $reviewForm = SyllabusReviewForm::join('srf_checklists', 'srf_checklists.srf_id', '=', 'syllabus_review_forms.srf_id')
    //         ->where('syllabus_review_forms.syll_id', $syll_id)
    //         ->select('srf_checklists.*', 'syllabus_review_forms.*')
    //         ->first();

    //     $syllabusVersions = Syllabus::where('syllabi.bg_id', $syll->bg_id)
    //         ->select('syllabi.*')
    //         ->get();
    //     $filename = 'syllabus.pdf';

    //     $data = [
    //         'title' => 'Welcome to Tutsmake.com',
    //         'date' => date('m/d/Y'),
    //         'syll' => $syll,
    //         'programOutcomes' => $programOutcomes,
    //         'poes' => $poes,
    //         'courseOutlinesFinals' => $courseOutlinesFinals,
    //         'copos' => $copos,
    //         'instructors' => $instructors,
    //         'courseOutlines' => $courseOutlines,
    //         'cotCos' => $cotCos,
    //         'cotCosF' => $cotCosF,
    //         'bLeaders' => $bLeaders,
    //         'bMembers' => $bMembers,
    //         'reviewForm' => $reviewForm,
    //         'syllabusVersions' => $syllabusVersions,
    //         'courseOutcomes' => $courseOutcomes,
    //     ];
    //     $pdf = PDF::loadView('PDF.syllabusPDF', $data);
    //     return $pdf->download('my_pdf.pdf');
    // }
    public function generateTOSPDF($tos_id)
    {
        $tos = Tos::where('tos_id', $tos_id)->join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'tos.bg_id')
            ->join('courses', 'courses.course_id', '=', 'tos.course_id')
            ->join('syllabi', 'syllabi.syll_id', '=', 'tos.syll_id')
            ->select('tos.*', 'bayanihan_groups.*', 'courses.*')->first();
        $course_outcomes = SyllabusCourseOutcome::where('syll_id', '=', $tos->syll_id)->select('syllabus_course_outcomes.*')->get();
        $tos_rows = TosRows::where('tos_rows.tos_id', '=', $tos_id)
            ->leftJoin('tos', 'tos.tos_id', '=', 'tos_rows.tos_id')
            ->select('tos.*', 'tos_rows.*')
            ->get();
        $bLeaders = BayanihanLeader::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_leaders.bg_id')
            ->join('tos', 'tos.bg_id', '=', 'bayanihan_groups.bg_id')
            ->join('users', 'users.id', '=', 'bayanihan_leaders.bg_user_id')
            ->select('bayanihan_leaders.*', 'users.*')
            ->where('tos.tos_id', '=', $tos_id)
            ->get();

        $bMembers = BayanihanMember::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_members.bg_id')
            ->join('tos', 'tos.bg_id', '=', 'bayanihan_members.bg_id')
            ->join('users', 'users.id', '=', 'bayanihan_members.bm_user_id')
            ->select('bayanihan_members.*', 'users.*')
            ->where('tos.tos_id', '=', $tos_id)
            ->get();
        $tosVersions = Tos::where('tos.bg_id', $tos->bg_id)
            ->select('tos.*')
            ->get();

        $chair = Syllabus::join('tos', 'tos.syll_id', '=', 'syllabi.syll_id')
            ->join('chairpeople', 'syllabi.department_id', '=', 'chairpeople.department_id')
            ->join('users', 'users.id', '=', 'chairpeople.user_id')
            ->first();

        $data = [
            'title' => 'Welcome to Tutsmake.com',
            'date' => date('m/d/Y'),
            'tos' => $tos,
            'course_outcomes' => $course_outcomes,
            'tos_rows' => $tos_rows,
            'bLeaders' => $bLeaders,
            'bMembers' => $bMembers,
            'tosVersions' => $tosVersions,
            'chair' => $chair,
        ];
        setlocale(LC_TIME, 'es');
        $date = date('Y-m-d');
        $document = new \PhpOffice\PhpWord\TemplateProcessor('doc/Tos-Template.docx');

        $document->setValue('tos_term', $data['tos']->tos_term);
        $document->setValue('course_code', $data['tos']->course_code);
        $document->setValue('course_title', $data['tos']->course_title);

        $document->setValue('bg_school_year', $data['tos']->bg_school_year);
        $document->setValue('course_semester', $data['tos']->course_semester);

        $document->setValue('tos_cpys', $data['tos']->tos_cpys);
        $document->setValue('chair_submitted_at', $data['tos']->chair_submitted_at);

        $coCount = count($course_outcomes);
        $document->cloneRow('syll_co_code', $coCount);
        foreach ($course_outcomes as $index => $co) {
            $syll_co_code = $co['syll_co_code'];
            $syll_co_description = $co['syll_co_description'];

            $document->setValue('syll_co_code#' . ($index + 1), $syll_co_code);
            $document->setValue('syll_co_description#' . ($index + 1), $syll_co_description);
        }

        $document->setValue('col_1_per', $data['tos']->col_1_per);
        $document->setValue('col_2_per', $data['tos']->col_2_per);
        $document->setValue('col_3_per', $data['tos']->col_3_per);
        $document->setValue('col_4_per', $data['tos']->col_4_per);

        $tosRowCount = count($tos_rows);
        $document->cloneRow('tos_r_topic', $tosRowCount);
        foreach ($tos_rows as $index => $co) {
            // $tos_r_topic = $co['tos_r_topic'];
            $tos_r_topic = nl2br(e($co['tos_r_topic']));
            $tos_r_no_hours = $co['tos_r_no_hours'];
            $tos_r_percent = $co['tos_r_percent'];
            $tos_r_no_items = $co['tos_r_no_items'];
            $tos_r_col_1 = $co['tos_r_col_1'];
            $tos_r_col_2 = $co['tos_r_col_2'];
            $tos_r_col_3 = $co['tos_r_col_3'];
            $tos_r_col_4 = $co['tos_r_col_4'];

            $document->setValue('tos_r_topic#' . ($index + 1), $tos_r_topic);
            $document->setValue('tos_r_no_hours#' . ($index + 1), $tos_r_no_hours);
            $document->setValue('tos_r_percent#' . ($index + 1), $tos_r_percent);
            $document->setValue('tos_r_no_items#' . ($index + 1), $tos_r_no_items);
            $document->setValue('tos_r_col_1#' . ($index + 1), $tos_r_col_1);
            $document->setValue('tos_r_col_2#' . ($index + 1), $tos_r_col_2);
            $document->setValue('tos_r_col_3#' . ($index + 1), $tos_r_col_3);
            $document->setValue('tos_r_col_4#' . ($index + 1), $tos_r_col_4);
        }

        $document->setValue('tos_no_items', $data['tos']->tos_no_items);
        $document->setValue('col_1_exp', $data['tos']->col_1_exp);
        $document->setValue('col_2_exp', $data['tos']->col_2_exp);
        $document->setValue('col_3_exp', $data['tos']->col_3_exp);
        $document->setValue('col_4_exp', $data['tos']->col_4_exp);

        $total_tos_r_no_hours = 0;
        $total_tos_r_percent = 0;
        foreach ($tos_rows as $tos_row) {
            $total_tos_r_no_hours += $tos_row->tos_r_no_hours;
            $total_tos_r_percent += $tos_row->tos_r_percent;
        }
        $document->setValue('t_total_tos_r_no_hours', $total_tos_r_no_hours);
        $document->setValue('t_total_tos_r_percent', $total_tos_r_percent);
        $document->setValue('prepared_by', "NOO");

        $btCount = count($bLeaders);

        $document->cloneRow('firstname', $btCount);
        foreach ($bLeaders as $index => $bLeader) {


            $prefix = $bLeader['prefix'];
            $firstname = $bLeader['firstname'];
            $lastname = $bLeader['lastname'];
            $suffix = $bLeader['suffix'];

            $document->setValue('prefix#' . ($index + 1), $prefix);
            $document->setValue('firstname#' . ($index + 1), $firstname);
            $document->setValue('lastname#' . ($index + 1), $lastname);
            $document->setValue('suffix#' . ($index + 1), $suffix);
        }


        $document->setValue('chairFirstname', $data['chair']->firstname);
        $document->setValue('chairLastname', $data['chair']->lastname);
        $document->setValue('chairPrefix', $data['chair']->prefix);
        $document->setValue('chairuffix', $data['chair']->suffix);


        $name = 'TOS' . '-' . "$tos->course_title"  . "-" . "$tos->status" . "-" . "$date" . '.docx';

        $document->saveAs(storage_path() . "/word/{$name}");
        return response()->download(storage_path() . "/word/{$name}");
    }

    public function generateSyllabusPDF($syll_id)
    {

        $syll = Syllabus::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'syllabi.bg_id')
            ->join('colleges', 'colleges.college_id', '=', 'syllabi.college_id')
            ->join('departments', 'departments.department_id', '=', 'syllabi.department_id') // Corrected
            ->join('curricula', 'curricula.curr_id', '=', 'syllabi.curr_id')
            ->join('courses', 'courses.course_id', '=', 'syllabi.course_id')
            ->where('syllabi.syll_id', '=', $syll_id)
            ->select('courses.*', 'bayanihan_groups.*', 'syllabi.*', 'departments.*', 'curricula.*', 'colleges.college_description', 'colleges.college_code')
            ->first();

        $programOutcomes = ProgramOutcome::join('departments', 'departments.department_id', '=', 'program_outcomes.department_id')
            ->join('syllabi', 'syllabi.department_id', '=', 'departments.department_id')
            ->where('syllabi.syll_id', '=', $syll_id)
            ->select('program_outcomes.*')
            ->get();
        $poes = POE::join('departments', 'departments.department_id', '=', 'poes.department_id')
            ->join('syllabi', 'syllabi.department_id', '=', 'departments.department_id')
            ->where('syllabi.syll_id', '=', $syll_id)
            ->select('poes.*')
            ->get();

        $courseOutcomes = SyllabusCourseOutcome::where('syll_id', '=', $syll_id)
            ->get();
        $copos = [];
        foreach ($courseOutcomes as $courseOutcome) {
            $copos = SyllabusCoPo::where('syll_co_id', '=', $courseOutcome->syll_co_id)
                ->get();
        }
        // $instructors = SyllabusInstructor::join('users', 'syllabus_instructors.syll_ins_user_id', '=', 'users.id')
        //     ->select('users.*', 'syllabus_instructors.*')
        //     ->get()
        //     ->groupBy('syll_id');
        $instructors = SyllabusInstructor::join('users', 'syllabus_instructors.syll_ins_user_id', '=', 'users.id')
            ->where('syllabus_instructors.syll_id', '=', $syll_id)
            ->select('users.*', 'syllabus_instructors.*')
            ->get();

        $courseOutlines = SyllabusCourseOutlineMidterm::where('syll_id', '=', $syll_id)
            ->with('courseOutcomes')
            ->orderBy('syll_row_no', 'asc')
            ->get();

        $courseOutlinesFinals = SyllabusCourseOutlinesFinal::where('syll_id', '=', $syll_id)
            ->with('courseOutcomes')
            ->orderBy('syll_row_no', 'asc')
            ->get();

        $cotCos = SyllabusCotCoM::join('syllabus_course_outcomes', 'syllabus_cot_cos_midterms.syll_co_id', '=', 'syllabus_course_outcomes.syll_co_id')
            ->select('syllabus_course_outcomes.*', 'syllabus_cot_cos_midterms.*')
            ->get()
            ->groupBy('syll_co_out_id');

        $cotCosF = SyllabusCotCoF::join('syllabus_course_outcomes', 'syllabus_cot_cos_finals.syll_co_id', '=', 'syllabus_course_outcomes.syll_co_id')
            ->select('syllabus_course_outcomes.*', 'syllabus_cot_cos_finals.*')
            ->get()
            ->groupBy('syll_co_out_id');

        $bLeaders = BayanihanLeader::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_leaders.bg_id')
            ->join('syllabi', 'syllabi.bg_id', '=', 'bayanihan_groups.bg_id')
            ->join('users', 'users.id', '=', 'bayanihan_leaders.bg_user_id')
            ->select('bayanihan_leaders.*', 'users.*')
            ->where('syllabi.syll_id', '=', $syll_id)
            ->get();

        $bMembers = BayanihanMember::join('bayanihan_groups', 'bayanihan_groups.bg_id', '=', 'bayanihan_members.bg_id')
            ->join('syllabi', 'syllabi.bg_id', '=', 'bayanihan_members.bg_id')
            ->join('users', 'users.id', '=', 'bayanihan_members.bm_user_id')
            ->select('bayanihan_members.*', 'users.*')
            ->where('syllabi.syll_id', '=', $syll_id)
            ->get();

        $reviewForm = SyllabusReviewForm::join('srf_checklists', 'srf_checklists.srf_id', '=', 'syllabus_review_forms.srf_id')
            ->where('syllabus_review_forms.syll_id', $syll_id)
            ->select('srf_checklists.*', 'syllabus_review_forms.*')
            ->first();

        $syllabusVersions = Syllabus::where('syllabi.bg_id', $syll->bg_id)
            ->select('syllabi.*')
            ->get();
        $filename = 'syllabus.pdf';

        $data = [
            'title' => 'Welcome to Tutsmake.com',
            'date' => date('m/d/Y'),
            'syll' => $syll,
            'programOutcomes' => $programOutcomes,
            'poes' => $poes,
            'courseOutlinesFinals' => $courseOutlinesFinals,
            'copos' => $copos,
            'instructors' => $instructors,
            'courseOutlines' => $courseOutlines,
            'cotCos' => $cotCos,
            'cotCosF' => $cotCosF,
            'bLeaders' => $bLeaders,
            'bMembers' => $bMembers,
            'reviewForm' => $reviewForm,
            'syllabusVersions' => $syllabusVersions,
            'courseOutcomes' => $courseOutcomes,
        ];
        setlocale(LC_TIME, 'es');
        $date = date('Y-m-d');
        $document = new \PhpOffice\PhpWord\TemplateProcessor('doc/Syllabus-Template.docx');

        $document->setValue('college_description', $data['syll']->college_description);
        $document->setValue('department_name', $data['syll']->department_name);

        $document->setValue('course_title', $data['syll']->course_title);
        $document->setValue('course_code', $data['syll']->course_code);

        $document->setValue('course_credit_unit', $data['syll']->course_credit_unit);
        $document->setValue('course_unit_lec', $data['syll']->course_unit_lec);
        $document->setValue('course_unit_lab', $data['syll']->course_unit_lab);

        $document->setValue('course_semester', $data['syll']->course_semester);
        $document->setValue('bg_school_year', $data['syll']->bg_school_year);
        $document->setValue('syll_class_schedule', nl2br(e($data['syll']->syll_class_schedule)));
        $document->setValue('syll_bldg_rm', $data['syll']->syll_bldg_rm);
        $document->setValue('course_pre_req', $data['syll']->course_pre_req);
        $document->setValue('course_co_req', $data['syll']->course_co_req);

        $instructorNames = [];
        $instructorEmails = [];
        $instructorPhones = [];

        foreach ($data['instructors'] as $instructor) {
            $instructorNames[] = $instructor->firstname . ' ' . $instructor->lastname;
            $instructorEmails[] = $instructor->email;
            $instructorPhones[] = $instructor->phone;
        }
        $document->setValue('instructor_names', implode(', ', $instructorNames));
        $document->setValue('instructor_emails', implode(', ', $instructorEmails));
        $document->setValue('instructor_phones', implode(', ', $instructorPhones));

        $document->setValue('syll_ins_consultation', $syll->syll_ins_consultation);
        $document->setValue('syll_ins_bldg_rm', $syll->syll_ins_bldg_rm);
        $document->setValue('syll_course_description', $syll->syll_course_description);
        $rowCount = count($courseOutlines);

        $document->cloneRow('syll_allotted_time', $rowCount);
        foreach ($courseOutlines as $index => $row) {
            $syll_allotted_time = nl2br(e($row['syll_allotted_time']));
            $syll_intended_learning = nl2br(e($row['syll_intended_learning']));
            $syll_topics = nl2br(e($row['syll_topics']));
            $syll_suggested_readings = nl2br(e($row['syll_suggested_readings']));
            $syll_learning_act = nl2br(e($row['syll_learning_act']));
            $syll_asses_tools = nl2br(e($row['syll_asses_tools']));
            $syll_grading_criteria = nl2br(e($row['syll_grading_criteria']));
            $syll_remarks = nl2br(e($row['syll_remarks']));

            $document->setValue('syll_allotted_time#' . ($index + 1), $syll_allotted_time);
            $document->setValue('syll_intended_learning#' . ($index + 1), $syll_intended_learning);
            $document->setValue('syll_topics#' . ($index + 1), $syll_topics);
            $document->setValue('syll_suggested_readings#' . ($index + 1), $syll_suggested_readings);
            $document->setValue('syll_learning_act#' . ($index + 1), $syll_learning_act);
            $document->setValue('syll_asses_tools#' . ($index + 1), $syll_asses_tools);
            $document->setValue('syll_grading_criteria#' . ($index + 1), $syll_grading_criteria);
            $document->setValue('syll_remarks#' . ($index + 1), $syll_remarks);

            $coOutId = $row['syll_co_out_id'];
            $courseOutcomes = $cotCos->get($coOutId, []);

            $cooString = '';
            $cooCount = count($courseOutcomes);
            foreach ($courseOutcomes as $cooIndex => $coo) {
                $cooString .= $coo['syll_co_code'];
                if ($cooIndex < $cooCount - 1) {
                    $cooString .= ', ';
                }
            }
            $document->setValue('syll_co_code#' . ($index + 1), nl2br(e($cooString)));
        }

        $rowCount_f = count($courseOutlinesFinals);
        $document->cloneRow('syll_allotted_time_f', $rowCount_f);
        foreach ($courseOutlinesFinals as $index => $row) {
            // Apply nl2br to every value before setting it
            $syll_allotted_time_f = nl2br(e($row['syll_allotted_time']));
            $syll_intended_learning_f = nl2br(e($row['syll_intended_learning']));
            $syll_topics_f = nl2br(e($row['syll_topics']));
            $syll_suggested_readings_f = nl2br(e($row['syll_suggested_readings']));
            $syll_learning_act_f = nl2br(e($row['syll_learning_act']));
            $syll_asses_tools_f = nl2br(e($row['syll_asses_tools']));
            $syll_grading_criteria_f = nl2br(e($row['syll_grading_criteria']));
            $syll_remarks_f = nl2br(e($row['syll_remarks']));

            $document->setValue('syll_allotted_time_f#' . ($index + 1), $syll_allotted_time_f);
            $document->setValue('syll_intended_learning_f#' . ($index + 1), $syll_intended_learning_f);
            $document->setValue('syll_topics_f#' . ($index + 1), $syll_topics_f);
            $document->setValue('syll_suggested_readings_f#' . ($index + 1), $syll_suggested_readings_f);
            $document->setValue('syll_learning_act_f#' . ($index + 1), $syll_learning_act_f);
            $document->setValue('syll_asses_tools_f#' . ($index + 1), $syll_asses_tools_f);
            $document->setValue('syll_grading_criteria_f#' . ($index + 1), $syll_grading_criteria_f);
            $document->setValue('syll_remarks_f#' . ($index + 1), $syll_remarks_f);

            $coOutId = $row['syll_co_out_id'];
            $courseOutcomes = $cotCos->get($coOutId, []);

            $cooString = '';
            $cooCount = count($courseOutcomes);
            foreach ($courseOutcomes as $cooIndex => $coo) {
                $cooString .= $coo['syll_co_code'];
                if ($cooIndex < $cooCount - 1) {
                    $cooString .= ', ';
                }
            }
            $document->setValue('syll_co_code_f#' . ($index + 1), nl2br(e($cooString)));
        }

        $poeCount = count($poes);
        $document->cloneRow('poe_code', $poeCount);
        foreach ($poes as $index => $poe) {
            $poe_code = $poe['poe_code'];
            $poe_description = $poe['poe_description'];

            $document->setValue('poe_code#' . ($index + 1), $poe_code);
            $document->setValue('poe_description#' . ($index + 1), $poe_description);
        }

        $poCount = count($programOutcomes);
        $document->cloneRow('po_letter', $poCount);
        foreach ($programOutcomes as $index => $po) {
            $po_letter = $po['po_letter'];
            $po_description = $po['po_description'];

            $document->setValue('po_letter#' . ($index + 1), $po_letter);
            $document->setValue('po_description#' . ($index + 1), $po_description);
        }

        $insCount = count($instructors);
        $document->cloneRow('ins_firstname', $insCount);
        foreach ($instructors as $index => $instructor) {
            $ins_firstname = $instructor['lastname'];
            $ins_lastname = $instructor['lastname'];

            $document->setValue('ins_firstname#' . ($index + 1), $ins_firstname);
            $document->setValue('ins_lastname#' . ($index + 1), $ins_lastname);
        }

        $document->setValue('syll_chair', $data['syll']->syll_chair);
        $document->setValue('syll_dean', $data['syll']->syll_dean);

        $syll_course_requirements = htmlspecialchars_decode(strip_tags($data['syll']->syll_course_requirements));
        $document->setValue('syll_course_requirements', $syll_course_requirements);

        // $syll_course_requirements = htmlspecialchars_decode($data['syll']->syll_course_requirements);
        // $document->setValue('syll_course_requirements', $syll_course_requirements);
        
        // $syll_course_requirements = $syll->syll_course_requirements;
        // $document->setValue('syll_course_requirements', $syll_course_requirements);

        $name = 'Syllabus' . '-' . "$syll->course_title"  . "-" . "$syll->status" . "-" . "$date" . '.docx';
        $document->saveAs(storage_path() . "/word/{$name}");

        return response()->download(storage_path() . "/word/{$name}");
    }
}
