<div class=" text-left">
    <div class="m-auto justify-center ml-[2.5%] mt-2">
        <input wire:model.live="search" type="text" class="border focus:outline-none focus:border-blue mb-6 border-black w-[20%] rounded p-1" placeholder="Search...">
        <button wire:click="applyFilters"><svg width="34px" class=" p-[3px] -mb-3" height="34px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M15.7955 15.8111L21 21M18 10.5C18 14.6421 14.6421 18 10.5 18C6.35786 18 3 14.6421 3 10.5C3 6.35786 6.35786 3 10.5 3C14.6421 3 18 6.35786 18 10.5Z" stroke="#2468d2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg></button>
        <select wire:model="filters.course_year_level" class="border cursor-pointer focus:outline-none focus:border-blue rounded p-1 w-[12%] ml-6" placeholder="Year level">
            <option value="" class="">Year level (All)</option>
            <option value="1st Year">1st Year</option>
            <option value="2nd Year">2nd Year</option>
            <option value="3rd Year">3rd Year</option>
            <option value="4th Year">4th Year</option>
            <option value="5th Year">5th Year</option>
        </select>
        <select wire:model="filters.course_semester" class="border focus:outline-none focus:border-blue cursor-pointer rounded p-1 w-[12%] ml-6" placeholder="Semester">
            <option value="">Semester (All)</option>
            <option value="1st Semester">1st Semester</option>
            <option value="2nd Semester">2nd Semester</option>
            <option value="Mid Year">Mid Year</option>
        </select>
        <select wire:model="filters.bg_school_year" class="border focus:outline-none focus:border-blue cursor-pointer rounded p-1 w-[12%] ml-6" placeholder="School Year">
            <option value="">School Year (All)</option>
            <option value="2023-2024">2023-2024</option>
            <option value="2024-2025">2024-2025</option>
            <option value="2025-2026">2025-2026</option>
            <option value="2026-2027">2026-2027</option>
            <option value="2027-2028">2027-2028</option>
            <option value="2028-2029">2028-2029</option>
            <option value="2029-2030">2029-2030</option>
        </select>

        <select wire:model="filters.status" class="border focus:outline-none focus:border-blue cursor-pointer rounded p-1 w-[12%] ml-6" placeholder="Semester">
            <option value="">Status (All)</option>
            <option value="Pending">Pending</option>
            <option value="Approved by Chair">Approved by Chair</option>
            <option value="Returned by Chair">Returned by Chair</option>
            <option value="Approved by Dean">Approved by Dean</option>
            <option value="Returned by Dean">Returned by Dean</option>
        </select>
        <button wire:click="applyFilters" class="bg-blue focus:outline-none rounded focus:border-blue cursor-pointer text-white p-[4px] -mb-3">Apply Filters</button>
    </div>
    <table class="border-collapse py-12 w-[95%] bg-white border m-auto justify-center">
        <thead>
            <tr class="bg-blue text-white text-left text-lg pb-2 border border-black">
                <th class="px-4 py-2">Course Title</th>
                <th class="px-4">Course Code</th>
                <th class="px-4">School Year</th>
                <th class="px-4">Semester</th>
                <th class="px-4">Version</th>
                <th class="px-4">Due</th>
                <th class="px-4">Time Remaining</th>
                <th class="px-4">Status</th>
                <th class="px-4">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-[#e5e7eb]">
            @foreach ($syllabi as $syllabus)
            <tr class="p-[100px] text-left">
                <td class="font-semibold px-4 py-6">{{ $syllabus->course_title }}</td>
                <td class="px-4">{{ $syllabus->course_code }}</td>
                <td class="px-4">{{ $syllabus->bg_school_year }}</td>
                <td class="px-4">{{ $syllabus->course_semester }}</td>
                <td class="px-4">Version {{$syllabus->version}}</td>
                <td class="px-4">{{$syllabus->dl_syll}}</td>
                @if($syllabus->chair_submitted_at != null)
                <td class="px-4" id="">Submitted</td>
                @elseif($syllabus->chair_submitted_at == null)
                <td class="px-4" id="remaining-time">...</td>
                @endif
                <td class="mr-[200px]">
                    <button class="
                    {{ $syllabus->status === 'Pending' ? 'w-[80%] bg-amber-100 text-amber-500 border-2 border-amber-300 rounded-lg' : '' }}
                    {{ $syllabus->status === 'Approved by Chair' ? 'w-[80%]  bg-emerald-200 text-emerald-600 border-2 border-emerald-400 rounded-lg' : '' }}
                    {{ $syllabus->status === 'Returned by Chair' ? 'w-[80%] bg-rose-300 text-rose-600 border-2 border-rose-500 rounded-lg' : ' ' }}
                    {{ $syllabus->status === 'Approved by Dean' ? 'w-[80%]  bg-emerald-200 text-emerald-600 border-2 border-emerald-400 rounded-lg' : '' }}
                    {{ $syllabus->status === 'Returned by Dean' ? 'w-[80%] bg-rose-300 text-rose-600 border-2 border-rose-500 rounded-lg' : ' ' }}">
                        {{$syllabus->status}}
                    </button>
                </td>
                <td class="px-4 m-auto float-left">
                    <div class="grid mb-2 mt-1 gap-4 md:grid-cols-2">
                        <form action="{{ route('bayanihanleader.viewSyllabus', $syllabus->syll_id) }}" method="GET">
                            @csrf
                            <button type="submit" class="hover:scale-105">
                                <svg class="-mb-5" width="30px" height="30px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <title>Edit</title>
                                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g id="Edit">
                                            <rect id="Rectangle" fill-rule="nonzero" x="0" y="0" width="24" height="24">
                                            </rect>
                                            <line x1="20" y1="20" x2="4" y2="20" id="Path" stroke="#58dd67" stroke-width="2" stroke-linecap="round">
                                            </line>
                                            <path d="M14.5858,4.41421 C15.3668,3.63316 16.6332,3.63316 17.4142,4.41421 L17.4142,4.41421 C18.1953,5.19526 18.1953,6.46159 17.4142,7.24264 L9.13096,15.5259 L6.10051,15.7279 L6.30254,12.6975 L14.5858,4.41421 Z" id="Path" stroke="#58dd67" stroke-width="2" stroke-linecap="round">
                                            </path>
                                        </g>
                                    </g>
                                </svg>
                            </button>
                        </form>
                        <form action="{{ route('bayanihanleader.destroySyllabus', $syllabus->syll_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this syllabus entry?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="mt-2 hover:scale-105">
                                <svg width="30px" height="30px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <title>Trash</title>
                                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g id="Trash">
                                            <rect id="Rectangle" fill-rule="nonzero" x="0" y="0" width="24" height="24">
                                            </rect>
                                            <path d="M6,6 L6.96683,19.5356 C6.98552,19.7973 7.20324,20 7.46556,20 L16.5344,20 C16.7968,20 17.0145,19.7973 17.0332,19.5356 L18,6" id="Path" stroke="#ff3813" stroke-width="2" stroke-linecap="round">
                                            </path>
                                            <line x1="4" y1="6" x2="20" y2="6" id="Path" stroke="#ff3813" stroke-width="2" stroke-linecap="round">
                                            </line>
                                            <line x1="10" y1="10" x2="10" y2="16" id="Path" stroke="#ff3813" stroke-width="2" stroke-linecap="round">

                                            </line>
                                            <line x1="14" y1="10" x2="14" y2="16" id="Path" stroke="#ff3813" stroke-width="2" stroke-linecap="round">
                                            </line>
                                            <path d="M15,6 C15,4.34315 13.6569,3 12,3 C10.3431,3 9,4.34315 9,6" id="Path" stroke="#ff3813" stroke-width="2" stroke-linecap="round">
                                            </path>
                                        </g>
                                    </g>
                                </svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $syllabi->links() }}
</div>