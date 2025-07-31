<?php

return [
    'options' => [
        'SCHOOL_PRODUCTS' => 1,
        'SCHOOL_GENDER' => 2,
        'SCHOOL_OWNERSHIP' => 3,
        'REGIONAL_LEVEL' => 4,
        'SCHOOL_POPULATION' => 5,
        'SCHOOL_TYPE' => 6,
        'SCHOOL_TERMS' => 7,
        // 'SCHOOL_OPTIONALS'  => ,

        // SUBJECTS

        'TECHNICAL_SUBJECTS' => 8,
        'OPTIONALS' => 9,
        'VOCATIONALS' => 10,
        'MATHEMATICS' => 11,
        'LANGUAGES' => 12,
        'SCIENCES' => 13,
        'HUMANITIES' => 14,
        'CLASS_STREAMS' => 15,

        // CLASSES

        'O_LEVEL' => 16,
        'A_LEVEL' => 17,
        'PRIMARY_LEVEL' => 18,
        'URPF' => 19,

        // SYSTEM SECTIONS

        // 1.SCHOOOL

        'School' => 16,

    ],
];


// Access specific features (Each of these Add,Delete,Edit,View) ====> Accessing specific user right 
// public static function userHasSpecificPermission($userId, $permissionFeature, $permissionName, $permissionScope)

// Have all Rights for that feauture (All of these Add,Delete,Edit,View) ====> Accessing all user crud
// public static function userHasAllPermissions($userId, $permissionName, $permissionScope)

// Access specific Section in the system (All of these Add,Delete,Edit,View) ====> Accessing all user crud
// public static function userPermissionSectionAccess($userId, $permissionName, $permissionScope)


// if (PermissionHelper::userPermissionSectionAccess(session('LoggedStudent'), 155, 'school')) {

// } else {
//     return redirect()->route('student.dashboard')->with('error', 'You do not have permission to access that feature!');
// }

// @if (PermissionHelper::userPermissionSectionAccess(session('LoggedStudent'), 155, 'school'))
// @else

// @endif

// @if (PermissionHelper::userHasSpecificPermission(session('LoggedStudent'), 'view_155', 155, 'school'))
// @else
// <p style="color: red">Access restricted</p>
// @endif