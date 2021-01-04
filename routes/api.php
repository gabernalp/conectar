<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::apiResource('users', 'UsersApiController');

    // Tags
    Route::apiResource('tags', 'TagsApiController');

    // Background Processes
    Route::post('background-processes/media', 'BackgroundProcessesApiController@storeMedia')->name('background-processes.storeMedia');
    Route::apiResource('background-processes', 'BackgroundProcessesApiController');

    // Courses
    Route::apiResource('courses', 'CoursesApiController');

    // Reference Types
    Route::apiResource('reference-types', 'ReferenceTypesApiController');

    // Operators
    Route::apiResource('operators', 'OperatorsApiController');

    // Contracts
    Route::apiResource('contracts', 'ContractsApiController');

    // Entities
    Route::apiResource('entities', 'EntitiesApiController');

    // Reference Objects
    Route::post('reference-objects/media', 'ReferenceObjectsApiController@storeMedia')->name('reference-objects.storeMedia');
    Route::apiResource('reference-objects', 'ReferenceObjectsApiController');

    // Challenges
    Route::post('challenges/media', 'ChallengesApiController@storeMedia')->name('challenges.storeMedia');
    Route::apiResource('challenges', 'ChallengesApiController');

    // Courses Hooks
    Route::apiResource('courses-hooks', 'CoursesHooksApiController');

    // Departments
    Route::apiResource('departments', 'DepartmentsApiController');

    // Cities
    Route::apiResource('cities', 'CitiesApiController');

    // Document Types
    Route::apiResource('document-types', 'DocumentTypeApiController');

    // Badges
    Route::post('badges/media', 'BadgesApiController@storeMedia')->name('badges.storeMedia');
    Route::apiResource('badges', 'BadgesApiController');

    // Devices
    Route::apiResource('devices', 'DevicesApiController');

    // Feedback Types
    Route::apiResource('feedback-types', 'FeedbackTypesApiController');

    // Points Rules
    Route::apiResource('points-rules', 'PointsRulesApiController');

    // Feedbacks Users
    Route::post('feedbacks-users/media', 'FeedbacksUsersApiController@storeMedia')->name('feedbacks-users.storeMedia');
    Route::apiResource('feedbacks-users', 'FeedbacksUsersApiController');

    // Course Schedules
    Route::apiResource('course-schedules', 'CourseSchedulesApiController');

    // Courses Users
    Route::apiResource('courses-users', 'CoursesUsersApiController');

    // Challenges Users
    Route::apiResource('challenges-users', 'ChallengesUsersApiController');

    // Resources Categories
    Route::apiResource('resources-categories', 'ResourcesCategoriesApiController');

    // Resources Subcategories
    Route::apiResource('resources-subcategories', 'ResourcesSubcategoriesApiController');

    // Subcategories Sets
    Route::apiResource('subcategories-sets', 'SubcategoriesSetsApiController');

    // Resources
    Route::post('resources/media', 'ResourcesApiController@storeMedia')->name('resources.storeMedia');
    Route::apiResource('resources', 'ResourcesApiController');

    // Events Schedules
    Route::post('events-schedules/media', 'EventsSchedulesApiController@storeMedia')->name('events-schedules.storeMedia');
    Route::apiResource('events-schedules', 'EventsSchedulesApiController');

    // Events Attendants
    Route::apiResource('events-attendants', 'EventsAttendantsApiController');

    // Meetings
    Route::post('meetings/media', 'MeetingsApiController@storeMedia')->name('meetings.storeMedia');
    Route::apiResource('meetings', 'MeetingsApiController');

    // Meeting Attendants
    Route::apiResource('meeting-attendants', 'MeetingAttendantsApiController');

    // Self Interested Users
    Route::apiResource('self-interested-users', 'SelfInterestedUsersApiController');

    // User Chain Blocks
    Route::apiResource('user-chain-blocks', 'UserChainBlocksApiController');

    // Resources Audits
    Route::apiResource('resources-audits', 'ResourcesAuditsApiController');
});
