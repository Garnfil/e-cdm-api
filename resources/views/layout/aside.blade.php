<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ URL::asset('assets/img/cdm-logo.png') }}" style="width: 50px;" alt="">
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2">E-CDM</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item active">
            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Users">Users</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('admin.students.index') }}" class="menu-link">
                        <div data-i18n="Students">Students</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.instructors.index') }}" class="menu-link">
                        <div data-i18n="Instructors">Instructors</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.guardians.index') }}" class="menu-link">
                        <div data-i18n="Guardians">Guardians</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.admins.index') }}" class="menu-link">
                        <div data-i18n="Admins">Admins</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item">
            <a href="{{ route('admin.institutes.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Institutes">Institutes</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{ route('admin.courses.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Courses">Courses</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{ route('admin.sections.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Sections">Sections</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{ route('admin.subjects.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Sections">Subjects</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{ route('admin.classes.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Sections">Classes</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="School Works">School Works</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('admin.assignments.index') }}" class="menu-link">
                        <div data-i18n="Assignments">Assignments</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.activities.index') }}" class="menu-link">
                        <div data-i18n="Activities">Activities</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.quizzes.index') }}" class="menu-link">
                        <div data-i18n="Quizzes">Quizzes</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.exams.index') }}" class="menu-link">
                        <div data-i18n="Exams">Exams</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item">
            <a href="{{ route('admin.attendances.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Sections">Attendances</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('admin.discussions.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Discussions">Discussions</div>
            </a>
        </li>
    </ul>
</aside>
