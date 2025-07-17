# Authentication Pattern Improvements

## Current Problem

You're frequently using this verbose pattern throughout your codebase:
```php
$user = Auth::guard(UserGuard::USER->value)->user();
```

This pattern appears **9+ times** across your application, leading to:
- Code repetition
- Reduced readability
- Maintenance overhead
- No type safety/IDE support

## Solution 1: Global Helper Functions ✅ IMPLEMENTED

**File:** `app/Helpers/AuthHelper.php`

### Available Functions:
```php
// Get authenticated user
$user = getAuthUser();

// Get user ID only
$userId = getAuthUserId();

// Get user as collection with optional field filtering
$userCollection = getAuthUserAsCollection(['id', 'username', 'email']);

// Check if user is authenticated
if (isUserAuthenticated()) {
    // User is logged in
}
```

### Usage Examples:
```php
// Before
$user = Auth::guard(UserGuard::USER->value)->user();

// After
$user = getAuthUser();

// Before
$user = collect(Auth::guard(UserGuard::USER->value)->user())
    ->only(['id', 'username', 'profile_picture_path'])
    ->toArray();

// After
$user = getAuthUserAsCollection(['id', 'username', 'profile_picture_path'])->toArray();

// Before
$userId = Auth::guard(UserGuard::USER->value)->user()->id;

// After
$userId = getAuthUserId();
```

## Solution 2: Trait Approach ✅ IMPLEMENTED

**File:** `app/Traits/HasUserAuthentication.php`

### Usage:
```php
use App\Traits\HasUserAuthentication;

class YourController extends Controller
{
    use HasUserAuthentication;

    public function index()
    {
        $user = $this->getAuthUser();
        $userId = $this->getAuthUserId();
        $userCollection = $this->getAuthUserAsCollection(['id', 'email']);
        
        if ($this->isUserAuthenticated()) {
            // Logic here
        }
    }
}
```

### Available Methods:
- `$this->getAuthUser()` - Get authenticated user
- `$this->getAuthUserId()` - Get user ID
- `$this->getAuthUserAsCollection($only)` - Get user as collection
- `$this->isUserAuthenticated()` - Check if authenticated
- `$this->getUserGuard()` - Get the guard instance

## Solution 3: Service Class Approach ✅ IMPLEMENTED

**File:** `app/Services/AuthUserService.php`

### Usage:
```php
use App\Services\AuthUserService;

class YourController extends Controller
{
    public function __construct(
        private AuthUserService $authUserService
    ) {}

    public function index()
    {
        $user = $this->authUserService->getUser();
        $userId = $this->authUserService->getUserId();
        $email = $this->authUserService->getUserAttribute('email');
        
        if ($this->authUserService->isAuthenticated()) {
            // Logic here
        }
    }
}
```

## Solution 4: Facade Pattern (Optional)

Create a custom facade for even cleaner syntax:

```php
// Usage would be:
$user = UserAuth::user();
$userId = UserAuth::id();
```

## Migration Strategy

### Phase 1: Controllers (High Impact)
Replace authentication calls in all controllers using the trait approach:

1. Add `use App\Traits\HasUserAuthentication;` to imports
2. Add `use HasUserAuthentication;` to class body
3. Replace `Auth::guard(UserGuard::USER->value)->user()` with `$this->getAuthUser()`

### Phase 2: Services (Medium Impact)
For service classes, either:
- Use dependency injection with `AuthUserService`
- Use global helper functions
- Add the trait if appropriate

### Phase 3: Views (Low Impact)
Replace Blade template authentication calls with helper functions.

## Recommended Approach by File Type

| File Type | Recommended Solution | Reason |
|-----------|---------------------|---------|
| Controllers | **Trait** | Clean OOP, protected methods, easy to implement |
| Services | **Service Injection** | Follows SOLID principles, testable |
| Helpers/Utilities | **Global Functions** | Simple, direct access |
| Blade Views | **Global Functions** | Easiest to use in templates |

## Example Refactoring

### Before:
```php
public function handleProfilePhotoUpload(UploadedFile $imageFile): void
{
    try {
        $systemUserImagePath = config('filesystems.paths.profile_photo');

        $user = collect(Auth::guard(UserGuard::USER->value)->user())
            ->only(['id', 'username', 'profile_picture_path'])
            ->toArray();
        $currentImagePath = $user['profile_picture_path'];
        
        // ... rest of method
    }
}
```

### After (using trait):
```php
public function handleProfilePhotoUpload(UploadedFile $imageFile): void
{
    try {
        $systemUserImagePath = config('filesystems.paths.profile_photo');

        $user = $this->getAuthUserAsCollection(['id', 'username', 'profile_picture_path'])->toArray();
        $currentImagePath = $user['profile_picture_path'];
        
        // ... rest of method
    }
}
```

### After (using global helper):
```php
public function handleProfilePhotoUpload(UploadedFile $imageFile): void
{
    try {
        $systemUserImagePath = config('filesystems.paths.profile_photo');

        $user = getAuthUserAsCollection(['id', 'username', 'profile_picture_path'])->toArray();
        $currentImagePath = $user['profile_picture_path'];
        
        // ... rest of method
    }
}
```

## Benefits of Each Approach

### Global Helper Functions
- ✅ Shortest syntax
- ✅ Works everywhere (controllers, services, views)
- ✅ Easy to implement
- ❌ Not easily mockable for testing
- ❌ Global namespace pollution

### Trait Approach
- ✅ Clean OOP design
- ✅ Easy to implement in existing classes
- ✅ Encapsulated methods
- ✅ IDE autocomplete support
- ❌ Only works in classes that can use traits

### Service Class
- ✅ Follows SOLID principles
- ✅ Easily testable/mockable
- ✅ Dependency injection friendly
- ✅ Can be extended with additional logic
- ❌ Requires dependency injection setup

## Testing Considerations

With these improvements, you can easily mock authentication in tests:

```php
// Testing with service approach
$mockAuthService = Mockery::mock(AuthUserService::class);
$mockAuthService->shouldReceive('getUser')->andReturn($testUser);

// Testing with trait approach
$controller = new YourController();
// You can still mock the underlying Auth facade
```

## Next Steps

1. ✅ **DONE:** Created helper functions in `AuthHelper.php`
2. ✅ **DONE:** Created `HasUserAuthentication` trait
3. ✅ **DONE:** Created `AuthUserService` class
4. ✅ **DONE:** Demonstrated refactoring in `UserDashboardController`
5. **TODO:** Gradually refactor other controllers and services
6. **TODO:** Add unit tests for the new authentication utilities
7. **TODO:** Update team coding standards documentation

## Files That Need Refactoring

Based on the analysis, these files contain the old pattern:
- `app/Http/Controllers/User/Profile/EmailAddressController.php`
- `app/Service/User/Profile/ProfileService.php`
- `app/Service/User/Profile/EmailAddressService.php`
- `app/Service/User/Verification/UserVerificationService.php`
- `app/Service/User/Dashboard/ResumeService.php`
- `app/Service/Common/FileStorageService.php`
- `app/Http/Controllers/User/Profile/ProfileController.php`
- `resources/views/components/nav-bar.blade.php`

Choose the approach that best fits your team's preferences and start refactoring gradually!