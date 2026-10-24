<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!-- Sidebar Brand -->
    <div class="sidebar-brand">
        <a href="#" class="brand-link">
            <img src="{{ asset('dist/assets/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image opacity-75 shadow" />
            <span class="brand-text fw-light">School SMS</span>
        </a>
    </div>

    <!-- Sidebar Wrapper -->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                
                <!-- Dashboard Link -->
                <li class="nav-item">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-header">ACADEMICS</li>

                <!-- Subject Matrix -->
                <li class="nav-item">
                    <a href="{{ route('subjects.index') }}" class="nav-link {{ request()->routeIs('subjects.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-journal-bookmark-fill"></i>
                        <p>Subject Syllabus Matrix</p>
                    </a>
                </li>

                <!-- Guardian Directory -->
                <li class="nav-item">
                    <a href="{{ route('guardians.index') }}" class="nav-link {{ request()->routeIs('guardians.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-shield-lock-fill text-indigo"></i>
                        <p>Guardian Directory</p>
                    </a>
                </li>

                <!-- Enrollments -->
                <li class="nav-item">
                    <a href="{{ route('enrollments.index') }}" class="nav-link {{ request()->routeIs('enrollments.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-bookmark-star-fill text-success"></i>
                        <p>Term Enrollments</p>
                    </a>
                </li>

                <!-- Grade Ledger -->
                <li class="nav-item">
                    <a href="{{ route('marks.index') }}" class="nav-link {{ request()->routeIs('marks.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-patch-check-fill text-danger"></i>
                        <p>Grade Sheets Ledger</p>
                    </a>
                </li>

                <!-- Student Management Dropdown -->
                <li class="nav-item {{ request()->routeIs('students.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('students.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-people-fill"></i>
                        <p>
                            Student Registry
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('students.index') }}" class="nav-link {{ request()->routeIs('students.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i><p>View Master Registry</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('students.register') }}" class="nav-link {{ request()->routeIs('students.register') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle text-primary"></i><p>Admit / Register Student</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Attendance Management Dropdown -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-calendar-check-fill"></i>
                        <p>
                            Attendance
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link"><i class="nav-icon bi bi-circle"></i><p>Daily Sheet</p></a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link"><i class="nav-icon bi bi-circle"></i><p>Attendance Reports</p></a>
                        </li>
                    </ul>
                </li>

                <!-- Examination & Marks Dropdown Module -->
                <li class="nav-item {{ request()->routeIs('exams.*') || request()->routeIs('exam-terms.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('exams.*') || request()->routeIs('exam-terms.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-file-earmark-spreadsheet-fill"></i>
                        <p>
                            Exams & Marks
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('exams.index') }}" class="nav-link {{ request()->routeIs('exams.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-calendar3-event-fill" style="color: #6f42c1;"></i><p>Exam Schedules</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('exam-terms.index') }}" class="nav-link {{ request()->routeIs('exam-terms.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-collection-fill" style="color: #fd7e14;"></i><p>Exam Terms</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link"><i class="nav-icon bi bi-circle"></i><p>Marks Entry Registry</p></a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header">MANAGEMENT &amp; REPORTS</li>

                <!-- Academic Reports and Automations Menu Item -->
                <li class="nav-item">
                    <a href="{{ route('reports.index') }}" class="nav-link {{ request()->is('reports*') ? 'active text-white' : '' }}">
                        <i class="nav-icon bi bi-file-earmark-bar-graph-fill text-primary"></i>
                        <p>Report Management Center</p>
                    </a>
                </li>

                <!-- Accounts & Billing Section -->
                <li class="nav-item">
                    <a href="{{ route('accounts.index') }}" 
                       class="nav-link d-flex align-items-center {{ request()->routeIs('accounts.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-bank2 {{ request()->routeIs('accounts.*') ? 'text-white' : 'text-success' }} me-2"></i>
                        <p>Exam Fee Ledger</p>
                        @php
                            $unpaidCount = \App\Models\ExamInvoice::whereIn('status', ['Unpaid', 'Partially Paid'])->count();
                        @endphp
                        @if($unpaidCount > 0)
                            <span class="badge rounded-pill bg-danger ms-auto font-monospace small" style="font-size: 11px;">
                                {{ $unpaidCount }}
                            </span>
                        @endif
                    </a>
                </li>

                <li class="nav-header">CAMPUS INFRASTRUCTURE</li>

                <!-- System Control Master Dropdown -->
                <li class="nav-item {{ request()->routeIs('campuses.*') || request()->routeIs('classes.*') || request()->routeIs('sections.*') || request()->routeIs('system.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('campuses.*') || request()->routeIs('classes.*') || request()->routeIs('sections.*') || request()->routeIs('system.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-gear-fill"></i>
                        <p>
                            System Control
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('campuses.index') }}" class="nav-link {{ request()->routeIs('campuses.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i><p>Campuses</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('classes.index') }}" class="nav-link {{ request()->routeIs('classes.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-diagram-3-fill"></i><p>Classes Registry</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('sections.index') }}" class="nav-link {{ request()->routeIs('sections.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle text-info"></i><p>Sections Matrix</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('system.rolloverView') }}" class="nav-link {{ request()->routeIs('system.rolloverView') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle-fill text-danger"></i><p>Auto Year Rollover</p>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>
    </div>
</aside>