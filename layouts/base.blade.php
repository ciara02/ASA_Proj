<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">

    {{-- <title>@yield('title')</title> --}}
    <link rel="icon" href="{{ asset('assets/img/official-logo-cropped.png') }}" type="image/png">
    <title>Automated Support Activity</title>

    <link
        rel="stylesheet"href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Bootstrap icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link href="{{ asset('assets/tab-layout/stylebase.css') }}" rel="stylesheet">

    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

    {{-- /* Loading screen Aug 14,2024 */ --}}
    <div id="loading-screen" style="display: none;">
        <div class="d-flex flex-column justify-content-center align-items-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <span class="loading-text">Loading...</span>
        </div>
    </div>
    {{-- -------------------------- --}}
    
    <div class="wrapper">
        <nav>
            <ul>
                <li>
                    <div class="nav-logo-container">
                        <a href="{{ route('tab-activity.index') }}" class="flex">
                            <span>ASA</span>
                        </a>
                    </div>
                </li>
                <li>
                    <a class="nav-item {{ request()->is('tab-activity*') ? 'active' : '' }}" href="#" id="activityMenu">
                        <i class="bi bi-house-door-fill" style="color: #6f42c1"></i>Activity
                        <i class="arrow bi bi-caret-down-fill" id="activityArrow"></i>
                    </a>
                    <ul class="submenu {{ request()->is('tab-activity*') ? 'show' : '' }}" id="activitySubmenu">
                        <li><a class="{{ request()->is('tab-activity') || request()->is('tab-activity/create-activity') ? 'active-submenu' : '' }}" href="{{ route('tab-activity.index') }}"><i class="bi bi-dot"></i>Activity Reports</a></li>
                        <li><a class="{{ request()->is('tab-activity/ActivityCompletionAcceptance') ? 'active-submenu' : '' }}" href="{{ route('tab-activity-completion-acceptance.index') }}"><i class="bi bi-dot"></i>Activity Completion Acceptance</a></li>
                    </ul>
                </li>
                <li>
                    <a class="nav-item {{ request()->routeIs('tab-point-system.index') || request()->routeIs('tab-point-system.create-merit-demerit') || request()->routeIs('tab-point-system.edit') ||  request()->routeIs('tab-point-system.edit-approval') ||  request()->routeIs('tab-point-system.approve') ||  request()->routeIs('tab-point-system.disapprove') ||  request()->routeIs('tab-point-system.updateLevel') ? 'active' : '' }}"
                        href="{{ route('tab-point-system.index') }}" id="pointSystem">
                        <i class="bi bi-star-fill" style="color: #ffc107"></i>Point System
                     </a>                                        
                </li>
                <li>
                    <a class="nav-item {{ request()->is('tab-isupport-service*') ? 'active' : '' }}" href="#" id="isupportMenu">
                        <i class="bi bi-inboxes-fill" style="color: #dc3545"></i>iSupport Services
                        <i class="arrow bi bi-caret-down-fill" id="isupportArrow"></i>
                    </a>
                    <ul class="submenu {{ request()->is('tab-isupport-service*') ? 'show' : '' }}" id="isupportSubmenu">
                        <li><a class="{{ request()->is('tab-isupport-service/implementation') || request()->is('tab-isupport-service/implementation/create') ? 'active-submenu' : '' }}" href="{{ route('tab-isupport-service.implementation.index') }}"><i class="bi bi-dot"></i>Implementation</a></li>
                        <li><a class="{{ request()->is('tab-isupport-service/maintenance-agreement') || request()->is('tab-isupport-service/maintenance-agreement/create') ? 'active-submenu' : '' }}" href="{{ route('tab-isupport-service.maintenance-agreement.index') }}"><i class="bi bi-dot"></i>Maintenance Agreement</a></li>
                        <li><a class="{{ request()->is('tab-isupport-service/project-sign-off*') ? 'active-submenu' : '' }}" href="{{ route('tab-isupport-service.project-sign-off.index') }}"><i class="bi bi-dot"></i>Project Sign-off</a></li>
                    </ul>                    
                </li>
                <li>
                    <a class="nav-item {{ request()->is('tab-report/index') ? 'active' : '' }}"
                        href="{{ route('tab-report.index') }}" id="report">
                        <i class="bi bi-bar-chart-line-fill" style="color: #e83e8c"></i>Reports
                    </a>
                </li>
                <li>
                    <a class="nav-item {{ request()->is('tab-certifications/certifications') ? 'active' : '' }}"
                        href="{{ route('tab-certifications.certification') }}" id="certification">
                        <i class="bi bi-mortarboard-fill" style="color: #20c997"></i>Certifications
                    </a>
                </li>
                <li>
                    <a class="nav-item {{ request()->is('tab-experience-center/experience-center') ? 'active' : '' }}"
                        href="{{ route('tab-experience-center.experience-center') }}" id="experienceCenter">
                        <i class="bi bi-briefcase-fill" style="color: #28a745"></i>Experience Center
                    </a>
                </li>

                {{-- Dissabled for future use --}}
                {{-- <li class="nav-item ">
                    <a class="nav-link {{'tab-manday/index' == request()->path() ? 'active' : ''}}" id="manday" href="{{ route('tab-manday.index') }}"><i class="bi bi-clock-history h4"></i><b> Manday</b></a>
                </li> --}}

                <li>
                    <span class="nav-item-username">
                        <i class="bi bi-person-fill" style="color: #adb5bd"></i>
                        @if($ldapEngineer && $ldapEngineer->fullName)
                        {{ $ldapEngineer->fullName }}
                         @else
                         
                         @endif
                    </span>
                </li>
                <li>
                    <a class="nav-item" href="/getlogout">
                        <i class="bi bi-door-closed-fill" style="color: #dc3545"></i>Logout
                    </a>
                </li>
            </ul>
        </nav>
        
        <main>
            @yield('content')
        </main>
    </div>

    <!-- Include your script.js file -->
    <script src="{{ asset('assets/tab-layout/stylebase_script.js') }}"></script>

    {{-- Handling the submenus in sidebar --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Toggle submenu on click for Activity
            const activityMenu = document.getElementById("activityMenu");
            const activitySubmenu = document.getElementById("activitySubmenu");
            const activityArrow = document.getElementById("activityArrow");

            activityMenu.addEventListener("click", function(e) {
                e.preventDefault();
                if (activitySubmenu.style.display === "none" || activitySubmenu.style.display === "") {
                    activitySubmenu.style.display = "block";
                    activityArrow.classList.remove("bi-caret-down-fill");
                    activityArrow.classList.add("bi-caret-up-fill");
                } else {
                    activitySubmenu.style.display = "none";
                    activityArrow.classList.remove("bi-caret-up-fill");
                    activityArrow.classList.add("bi-caret-down-fill");
                }
            });

            // Toggle submenu on click for iSupport Services
            const isupportMenu = document.getElementById("isupportMenu");
            const isupportSubmenu = document.getElementById("isupportSubmenu");
            const isupportArrow = document.getElementById("isupportArrow");

            isupportMenu.addEventListener("click", function(e) {
                e.preventDefault();
                if (isupportSubmenu.style.display === "none" || isupportSubmenu.style.display === "") {
                    isupportSubmenu.style.display = "block";
                    isupportArrow.classList.remove("bi-caret-down-fill");
                    isupportArrow.classList.add("bi-caret-up-fill");
                } else {
                    isupportSubmenu.style.display = "none";
                    isupportArrow.classList.remove("bi-caret-up-fill");
                    isupportArrow.classList.add("bi-caret-down-fill");
                }
            });
        });

        /* Loading screen Aug 14,2024 */
        document.addEventListener('DOMContentLoaded', function() {
        const navLinks = document.querySelectorAll('a.nav-item, a.nav-link');
        const submenuLinks = document.querySelectorAll('nav ul li ul.submenu a');
        const loadingScreen = document.getElementById('loading-screen');

        // Function to show the loading screen
        function showLoadingScreen() {
            console.log('Showing loading screen');
            loadingScreen.style.display = 'flex';
        }

        function hideLoadingScreen() {
            console.log('Hiding loading screen');
            loadingScreen.style.display = 'none';
        }

        // Add event listeners for regular nav links
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                // Check if the clicked link has a submenu
                if (!link.nextElementSibling || !link.nextElementSibling.classList.contains('submenu')) {
                    showLoadingScreen();
                }
            });
        });

        // Add event listeners for submenu links
        submenuLinks.forEach(link => {
            link.addEventListener('click', showLoadingScreen);
        });
    });
   /* Loading screen Aug 14,2024 */


    </script>
</body>

</html>
