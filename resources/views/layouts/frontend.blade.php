<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/css/perfect-scrollbar.min.css" rel="stylesheet" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
    @yield('styles')
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @guest
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('frontend.home') }}">
                                    {{ __('Dashboard') }}
                                </a>
                            </li>
                        @endguest
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if(Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                                    <a class="dropdown-item" href="{{ route('frontend.profile.index') }}">{{ __('My profile') }}</a>

                                    @can('user_management_access')
                                        <a class="dropdown-item disabled" href="#">
                                            {{ trans('cruds.userManagement.title') }}
                                        </a>
                                    @endcan
                                    @can('permission_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.permissions.index') }}">
                                            {{ trans('cruds.permission.title') }}
                                        </a>
                                    @endcan
                                    @can('role_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.roles.index') }}">
                                            {{ trans('cruds.role.title') }}
                                        </a>
                                    @endcan
                                    @can('user_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.users.index') }}">
                                            {{ trans('cruds.user.title') }}
                                        </a>
                                    @endcan
                                    @can('user_alert_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.user-alerts.index') }}">
                                            {{ trans('cruds.userAlert.title') }}
                                        </a>
                                    @endcan
                                    @can('user_chain_block_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.user-chain-blocks.index') }}">
                                            {{ trans('cruds.userChainBlock.title') }}
                                        </a>
                                    @endcan
                                    @can('global_var_access')
                                        <a class="dropdown-item disabled" href="#">
                                            {{ trans('cruds.globalVar.title') }}
                                        </a>
                                    @endcan
                                    @can('tag_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.tags.index') }}">
                                            {{ trans('cruds.tag.title') }}
                                        </a>
                                    @endcan
                                    @can('entity_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.entities.index') }}">
                                            {{ trans('cruds.entity.title') }}
                                        </a>
                                    @endcan
                                    @can('department_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.departments.index') }}">
                                            {{ trans('cruds.department.title') }}
                                        </a>
                                    @endcan
                                    @can('city_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.cities.index') }}">
                                            {{ trans('cruds.city.title') }}
                                        </a>
                                    @endcan
                                    @can('document_type_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.document-types.index') }}">
                                            {{ trans('cruds.documentType.title') }}
                                        </a>
                                    @endcan
                                    @can('device_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.devices.index') }}">
                                            {{ trans('cruds.device.title') }}
                                        </a>
                                    @endcan
                                    @can('feedback_type_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.feedback-types.index') }}">
                                            {{ trans('cruds.feedbackType.title') }}
                                        </a>
                                    @endcan
                                    @can('points_rule_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.points-rules.index') }}">
                                            {{ trans('cruds.pointsRule.title') }}
                                        </a>
                                    @endcan
                                    @can('educational_background_access')
                                        <a class="dropdown-item disabled" href="#">
                                            {{ trans('cruds.educationalBackground.title') }}
                                        </a>
                                    @endcan
                                    @can('background_process_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.background-processes.index') }}">
                                            {{ trans('cruds.backgroundProcess.title') }}
                                        </a>
                                    @endcan
                                    @can('course_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.courses.index') }}">
                                            {{ trans('cruds.course.title') }}
                                        </a>
                                    @endcan
                                    @can('challenge_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.challenges.index') }}">
                                            {{ trans('cruds.challenge.title') }}
                                        </a>
                                    @endcan
                                    @can('badge_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.badges.index') }}">
                                            {{ trans('cruds.badge.title') }}
                                        </a>
                                    @endcan
                                    @can('programacion_de_ciclo_access')
                                        <a class="dropdown-item disabled" href="#">
                                            {{ trans('cruds.programacionDeCiclo.title') }}
                                        </a>
                                    @endcan
                                    @can('course_schedule_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.course-schedules.index') }}">
                                            {{ trans('cruds.courseSchedule.title') }}
                                        </a>
                                    @endcan
                                    @can('courses_user_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.courses-users.index') }}">
                                            {{ trans('cruds.coursesUser.title') }}
                                        </a>
                                    @endcan
                                    @can('challenges_user_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.challenges-users.index') }}">
                                            {{ trans('cruds.challengesUser.title') }}
                                        </a>
                                    @endcan
                                    @can('feedbacks_user_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.feedbacks-users.index') }}">
                                            {{ trans('cruds.feedbacksUser.title') }}
                                        </a>
                                    @endcan
                                    @can('referencium_access')
                                        <a class="dropdown-item disabled" href="#">
                                            {{ trans('cruds.referencium.title') }}
                                        </a>
                                    @endcan
                                    @can('reference_type_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.reference-types.index') }}">
                                            {{ trans('cruds.referenceType.title') }}
                                        </a>
                                    @endcan
                                    @can('reference_object_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.reference-objects.index') }}">
                                            {{ trans('cruds.referenceObject.title') }}
                                        </a>
                                    @endcan
                                    @can('courses_hook_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.courses-hooks.index') }}">
                                            {{ trans('cruds.coursesHook.title') }}
                                        </a>
                                    @endcan
                                    @can('operadore_access')
                                        <a class="dropdown-item disabled" href="#">
                                            {{ trans('cruds.operadore.title') }}
                                        </a>
                                    @endcan
                                    @can('operator_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.operators.index') }}">
                                            {{ trans('cruds.operator.title') }}
                                        </a>
                                    @endcan
                                    @can('contract_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.contracts.index') }}">
                                            {{ trans('cruds.contract.title') }}
                                        </a>
                                    @endcan
                                    @can('resources_library_access')
                                        <a class="dropdown-item disabled" href="#">
                                            {{ trans('cruds.resourcesLibrary.title') }}
                                        </a>
                                    @endcan
                                    @can('resource_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.resources.index') }}">
                                            {{ trans('cruds.resource.title') }}
                                        </a>
                                    @endcan
                                    @can('resources_category_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.resources-categories.index') }}">
                                            {{ trans('cruds.resourcesCategory.title') }}
                                        </a>
                                    @endcan
                                    @can('resources_subcategory_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.resources-subcategories.index') }}">
                                            {{ trans('cruds.resourcesSubcategory.title') }}
                                        </a>
                                    @endcan
                                    @can('subcategories_set_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.subcategories-sets.index') }}">
                                            {{ trans('cruds.subcategoriesSet.title') }}
                                        </a>
                                    @endcan
                                    @can('resources_audit_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.resources-audits.index') }}">
                                            {{ trans('cruds.resourcesAudit.title') }}
                                        </a>
                                    @endcan
                                    @can('event_access')
                                        <a class="dropdown-item disabled" href="#">
                                            {{ trans('cruds.event.title') }}
                                        </a>
                                    @endcan
                                    @can('events_schedule_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.events-schedules.index') }}">
                                            {{ trans('cruds.eventsSchedule.title') }}
                                        </a>
                                    @endcan
                                    @can('events_attendant_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.events-attendants.index') }}">
                                            {{ trans('cruds.eventsAttendant.title') }}
                                        </a>
                                    @endcan
                                    @can('community_access')
                                        <a class="dropdown-item disabled" href="#">
                                            {{ trans('cruds.community.title') }}
                                        </a>
                                    @endcan
                                    @can('meeting_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.meetings.index') }}">
                                            {{ trans('cruds.meeting.title') }}
                                        </a>
                                    @endcan
                                    @can('meeting_attendant_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.meeting-attendants.index') }}">
                                            {{ trans('cruds.meetingAttendant.title') }}
                                        </a>
                                    @endcan
                                    @can('self_interested_access')
                                        <a class="dropdown-item disabled" href="#">
                                            {{ trans('cruds.selfInterested.title') }}
                                        </a>
                                    @endcan
                                    @can('self_interested_user_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.self-interested-users.index') }}">
                                            {{ trans('cruds.selfInterestedUser.title') }}
                                        </a>
                                    @endcan

                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @if(session('message'))
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-success" role="alert">{{ session('message') }}</div>
                        </div>
                    </div>
                </div>
            @endif
            @if($errors->count() > 0)
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger">
                                <ul class="list-unstyled mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @yield('content')
        </main>
    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/perfect-scrollbar.min.js"></script>
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
<script src="{{ asset('js/main.js') }}"></script>
@yield('scripts')

</html>