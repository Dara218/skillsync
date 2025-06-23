<?php

return [
    'enums' => [
        'user_role' => [
            'job_seeker' => 'Job Seeker',
            'admin' => 'Admin',
        ],
        'application_status' => [
            'pending' => 'Pending',
            'reviewed' => 'Reviewed',
            'accepted' => 'Accepted',
            'rejected' => 'Rejected',
        ],
        'job_type' => [
            'full_time' => 'Full Time',
            'part_time' => 'Part Time',
            'remote_time' => 'Remote Time',
            'internship'=> 'Internship',
        ],
    ],

    'label' => [
        'email' => 'Email',
        'password' => 'Password',
        'not_a_member' => 'Not a member?',
        'already_a_member' => 'Already a member?',
        'full_name' => 'Full name',
        'role' => 'Role',
        'user_login' => 'Login',
        'signup' => 'Signup',
        'verification_code' => 'Verification Code',
        'suggested_jobs' => 'Suggested Jobs',
        'my_applications' => 'My Applications',
        'resume_uploaded' => 'Resume uploaded',
        'date_applied' => 'Date Applied',
        'no_uploaded_resume' => 'No uploaded resume',
        'no_info' => 'No info.',
        'no_description' => 'No description.',
        'jobs' => 'Jobs',
    ],

    'button' => [
        'login' => 'Login',
        'register' => 'Register',
        'verify' => "Verify",
        'apply' => 'Apply',
        'reviewed' => 'Reviewed',
        'view_or_replace_resume' => 'View / Replace Resume',
        'browse_all_jobs' => 'Browse All Jobs',
        'update_profile' => 'Update Profile',
        'my_applications' => 'My Applications',
        'delete' => 'Delete',
        'upload' => 'Upload',
        'view' => 'View',
        'search' => 'Search',
        'go_back' => 'Go Back',
    ],

    'link' => [
        'become_a_member' => 'Become a member',
        'login_here' => 'Login here',
        'browse_all_jobs' => 'Browse All Jobs',
        'update_profile' => 'Update Profile',
        'my_applications' => 'My Applications',
        'dashboard' => 'Dashboard',
        'logout' => 'Logout',
    ],

    'title' => [
        'signup' => 'Signup',
        'user_login' => 'Login',
        'user_verify' => 'Account Verification',
        'dashboard' => 'Dashboard',
        'jobs' => 'Jobs',
        'error' => ':PAGE_TITLE',
    ],

    'note' => [
        'password' => [
            '8_min_chars' => 'Is at least 8 characters long',
            'uppercase' => 'Includes uppercase letters',
            'lowercase' => 'Includes lowercase letters',
            'numbers' => 'Includes numbers',
            'symbols' => 'Includes symbols',
        ],
        'enter_6_digit_verification_code' => 'Enter a 6 digit verification code sent to your registered email address.',
        'dashboard_welcome' => 'Welcome back, :name! Ready to find your next opportunity?',
    ],

    'placeholder' => [
        'search_for_jobs' => 'Search for jobs...',
    ],

    'errors' => [
        'not_found' => [
            'title' => 'Not found.',
            'message' => 'The page you are looking for could not be found.',
        ],
        'bad_request' => [
            'title' => 'Bad request.',
            'message' => 'The server could not process the request due to invalid input.',
        ],
        'unauthorized' => [
            'title' => 'Authentication required.',
            'message' => 'You need to be authenticated to access this page.',
        ],
        'forbidden' => [
            'title' => 'Access denied.',
            'message' => 'You do not have permission to access this page.',
        ],
        'expired' => [
            'title' => 'Page has expired.',
            'message' => 'The page has expired. Please try again.',
        ],
        'too_many_request' => [
            'title' => 'Too many requests.',
            'message' => 'Access is temporarily restricted due to too many requests.',
        ],
        'internal_server_error' => [
            'title' => 'Internal server error.',
            'message' => 'An error occurred on the server. Please try again later.',
        ],
        'bad_gateway' => [
            'title' => 'Bad gateway.',
            'message' => 'Received an invalid response from the gateway server.',
        ],
        'service_unavailable' => [
            'title' => 'Service unavailable.',
            'message' => 'The service is currently unavailable. Please try again later.',
        ],
        'gateway_timeout' => [
            'title' => 'Gateway timeout.',
            'message' => 'The gateway server did not respond in time.',
        ],
    ],
];
