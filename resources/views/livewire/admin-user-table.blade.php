<div class=" mx-auto sm:p-2 text-gray-100 m-10 bg-gray-100">
    <div class="">
        <!-- Search Button  -->
        <input wire:model.live="search" class="form-control border w-80 border-sePrimary rounded p-1 bg-gray-200 px-2 -mt-[100px] mb-4" type="text" placeholder="Search...">
        <button wire:click="applyFilters"><svg width="15px" height="15px" class="w-[30px] -mb-[8px] ml-1 p-[2px] h-[30px] rounded bg-blue" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M15.7955 15.8111L21 21M18 10.5C18 14.6421 14.6421 18 10.5 18C6.35786 18 3 14.6421 3 10.5C3 6.35786 6.35786 3 10.5 3C14.6421 3 18 6.35786 18 10.5Z" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg></button>

        <!-- Filters  -->
        <div class="float-right -mt-[15px]">
            <select wire:model="roles_filters" class="form-control border w-80 border-sePrimary rounded p-1 bg-gray-200 px-2" name="roleFilter" id="roleFilter" placeholder="Year level">
                <option value="">Roles</option>
                <option value="1">Admins</option>
                <option value="2">Deans</option>
                <option value="3">Chairperson</option>
                <option value="4">Bayanihan Leaders</option>
                <option value="5">Bayanihan Teachers</option>
            </select>
            <button wire:click="applyFilters" class="bg-blue text-white p-1 mt-3 px-2 hover:drop-shadow-md rounded font-semibold">Apply Filters</button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full p-6 text-2xs text-left whitespace-nowrap">
                <colgroup>
                    <col class="w-5">
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col class="w-5">
                </colgroup>
                <thead>
                    <tr class="bg-blue text-white">
                        <th class="p-3">ID</th>
                        <th class="p-3">Prefix</th>
                        <th class="p-3">First Name</th>
                        <th class="p-3">Last Name</th>
                        <th class="p-3">Suffix</th>
                        <th class="p-3">Phone</th>
                        <th class="p-3">Email</th>
                        <th class="p-3 m-auto text-center">Action</th>
                        <span class="sr-only text-align-center">Edit</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="border-b text-black divide-y divide-[#e5e7eb] bg-[#f9fafb] ">
                    @foreach ($users as $user)
                    <tr>
                        <td class=" px-3 text-2xl font-medium dark:text-gray-400">{{ $user->id }}</td>
                        <td class="px-3 py-2">
                            <p>{{ $user->prefix }}</p>
                        </td>
                        <td class="px-3 py-2">
                            <p>{{ $user->firstname }}</p>
                        </td>
                        <td class="px-3 py-2">
                            <p>{{ $user->lastname }}</p>
                        </td>
                        <td class="px-3 py-2">
                            <p>{{ $user->suffix }}</p>
                        </td>
                        <td class="px-3 py-2">
                            <p>{{ $user->phone }}</p>
                        </td>
                        <td class="px-3 py-2">
                            <p>{{ $user->email }}</p>
                        </td>
                        <td class="flex justify-center">
                            <!-- <form action="{{ route('admin.edit', $user->id) }}" method="GET">
                                @csrf
                                <button type="submit" class="btn btn-primary text-black hover:text-white text-sm px-2 py-1 hover:bg-blue rounded-lg">Edit Details</button>
                            </form>

                            <form action="{{ route('admin.editRoles', $user->id) }}" method="GET">
                                @csrf
                                <button type="submit" class="btn btn-primary text-black px-2 hover:text-white text-sm py-1 hover:bg-blue rounded-lg">Edit Roles</button>
                            </form> -->

                        <div class="m-auto flex inline space-x-4">
                            <button type="button" class="-mt-1 edit-btn hover:scale-110 rounded-full">
                                <svg fill="#58dd67" width="25px" height="25px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2,21H8a1,1,0,0,0,0-2H3.071A7.011,7.011,0,0,1,10,13a5.044,5.044,0,1,0-3.377-1.337A9.01,9.01,0,0,0,1,20,1,1,0,0,0,2,21ZM10,5A3,3,0,1,1,7,8,3,3,0,0,1,10,5ZM20.207,9.293a1,1,0,0,0-1.414,0l-6.25,6.25a1.011,1.011,0,0,0-.241.391l-1.25,3.75A1,1,0,0,0,12,21a1.014,1.014,0,0,0,.316-.051l3.75-1.25a1,1,0,0,0,.391-.242l6.25-6.25a1,1,0,0,0,0-1.414Zm-5,8.583-1.629.543.543-1.629L19.5,11.414,20.586,12.5Z" />
                                </svg>
                                <span class="ml-1 fas fa-angle-down rounded w-10"></span>
                            </button>

                            <ul class="dropdown-menu absolute hidden bg-white rounded shadow-lg">
                                <li class="px-1 py-1 hover:bg-blue rounded">
                                    <a href="{{ route('admin.edit', $user->id) }}" class="dropdown-item text-black  hover:text-white">
                                        Edit Details
                                    </a>
                                </li>
                                <li class="px-1 py-1 hover:bg-blue rounded">
                                    <a href="{{ route('admin.editRoles', $user->id) }}" class="dropdown-item text-black hover:bg-blue hover:text-white">
                                        Edit Roles
                                    </a>
                                </li>
                            </ul>

                            <form action="{{ route('admin.destroy',$user->id) }}" method="Post">
                                @csrf
                                @method('DELETE')
                                <button class="mt-3 text-black hover:text-white hover:scale-110 text-sm rounded-lg" type="submit" class="">
                                    <svg width="25px" height="25px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
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
            <div class="mt-4">
                <div class="flex justify-center">
                    <span class="text-gray-600 text-sm">Page {{ $users->currentPage() }} of {{ $users->lastPage() }}</span>
                </div>
                {{ $users->links() }} <!-- Pagination links -->
            </div>
        </div>
    </div>
</div>