<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;


class Usercontroller extends Controller
{
    private function assignRoleByEmailOnLogin(User $user): void
    {
        $email = strtolower((string) $user->email);

        $superAdmins = [
            'yahya@gmail.com',
        ];

        $admins = [
            'laadam@gmail.com',
            'ezzaytouni@gmail.com',
            'irfane@gmail.com',
            'bahloul@gmail.com',
            'mousalim@gmail.com',
        ];

        $teachers = [
            'teacher@example.com',
            'teacher@exemple.com',
        ];

        $mappedRole = in_array($email, $superAdmins, true)
            ? 'Super Admin'
            : (in_array($email, $admins, true) ? 'Admin' : (in_array($email, $teachers, true) ? 'Teacher' : null));

        if (! $mappedRole) {
            if (! $user->hasAnyRole(['Super Admin', 'Admin', 'Teacher', 'Student'])) {
                $user->syncRoles(['Student']);
                $user->role = 'participant';
                $user->save();
            }

            return;
        }

        $roleExists = Role::query()
            ->where('name', $mappedRole)
            ->where('guard_name', 'web')
            ->exists();

        if ($roleExists) {
            $user->syncRoles([$mappedRole]);

            if ($mappedRole === 'Super Admin' || $mappedRole === 'Admin') {
                $user->role = 'admin';
            } elseif ($mappedRole === 'Teacher') {
                $user->role = 'formateur';
            } else {
                $user->role = 'participant';
            }

            $user->save();
        }
    }

    
    // condition roles to redirect
    private function redirectToRoleHome(User $user)
    {
        if ($user->hasRole('Super Admin') || $user->hasRole('Admin')) {
            return redirect()->route('dashboard');
        }

        if ($user->hasRole('Teacher')) {
            return redirect()->route('formation');
        }

        return redirect()->route('formation');
    }

    // login 
    public function login(){
  return view('login');
    }
    // register
    public function register (){
           return view('register');
    }


     // dasboard page
      public function dash(){
        $this->authorize('view dashboard');

        return view('dashboard', [
            'totalUsers' => User::count(),
            'newUsers' => User::where('created_at', '>=', now()->subMonth())->count(),
            'totalFormations' => Formation::count(),
            'newFormations' => Formation::where('created_at', '>=', now()->subMonths(3))->count(),
            'activeSessions' => 0,
            'sessionsThisWeek' => 0,
            'totalInscriptions' => 0,
            'pendingInscriptions' => 0,
            'activities' => []
        ]);
    }

  // formation
     public function formation(){
          $this->authorize('view formations');

    $formations = Formation::paginate(10);
    
    return view('addformation', [
        'formations' => $formations,
        'beginnerCount' => Formation::where('level', 'Beginner')->count(),
        'intermediateCount' => Formation::where('level', 'Intermediate')->count(),
        'advancedCount' => Formation::where('level', 'Advanced')->count(),
    ]);
    }

    // users array
    public function users()
    {
        $this->authorize('manage users');

        $users = User::with('roles')->latest()->get();

        return view('users', [
            'users' => $users,
            'totalUsers' => $users->count(),
            'activeUsers' => $users->where('status', 'active')->count(),
            'inactiveUsers' => $users->where('status', 'inactive')->count(),
            'newUsersThisMonth' => $users->where('created_at', '>=', now()->subMonth())->count(),
            'superAdminUsers' => $users->filter(fn (User $user) => $user->hasRole('Super Admin'))->count(),
            'adminUsers' => $users->filter(fn (User $user) => $user->hasRole('Admin'))->count(),
            'teacherUsers' => $users->filter(fn (User $user) => $user->hasRole('Teacher'))->count(),
            'studentUsers' => $users->filter(fn (User $user) => $user->hasRole('Student'))->count(),
        ]);
    }
     // role to teacher
    public function assignTeacherRole(Request $request)
    {
        $this->authorize('manage users');

        $credentials = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $email = strtolower(trim($credentials['email']));
        $user = User::whereRaw('LOWER(email) = ?', [$email])->first();

        if (! $user) {
            throw ValidationException::withMessages([
                'email' => __('messages.auth.emailNotFound'),
            ]);
        }

        if ($user->hasRole('Super Admin')) {
            throw ValidationException::withMessages([
                'email' => 'Super Admin role cannot be changed from here.',
            ]);
        }

        $user->syncRoles(['Teacher']);
        $user->role = 'formateur';
        $user->save();

        return redirect()->route('users.index')->with('success', 'Teacher role assigned successfully.');
    }

// login logic
public function loginPost(Request $req)
{
    $credentials = $req->validate([
        'email' => ['required', 'email'],
        'password' => ['required', 'string'],
    ], [
        'email.required' => __('messages.auth.emailRequired'),
        'email.email' => __('messages.auth.enterValidEmail'),
        'password.required' => __('messages.auth.passwordRequired'),
    ]);

    $user = User::where('email', $credentials['email'])->first();

    if (! $user) {
        throw ValidationException::withMessages([
            'email' => __('messages.auth.emailNotFound'),
        ]);
    }

    if (! Hash::check($credentials['password'], $user->password)) {
        throw ValidationException::withMessages([
            'password' => __('messages.auth.incorrectPassword'),
        ]);
    }

    Auth::login($user, $req->boolean('remember'));
    $req->session()->regenerate();
    $this->assignRoleByEmailOnLogin($user);

    return $this->redirectToRoleHome($user);
}

// register logic 
public function registerPost(Request $req)
{
    $req->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email',
        'phone'    => 'required|string|max:20',
        'password' => 'required|min:8|confirmed',
        'language' => 'required|in:fr,en',
        'status'   => 'required|in:active,inactive',
    ]);

    $user = User::create([
        'name'     => $req->name,
        'email'    => $req->email,
        'phone'    => $req->phone,
        'password' => Hash::make($req->password),
        'language' => $req->language,
        'status'   => $req->status,
    ]);

    $user->assignRole('Student');


    return $this->redirectToRoleHome($user)->with('success', __('messages.auth.registerSuccess'));
}



// store formations
   public function store(Request $request)
{
    $this->authorize('manage formations');

    $request->validate([
        'title_fr'             => 'required|string|max:255',
        'level'                => 'nullable|in:Beginner,Intermediate,Advanced',
        'duration'             => 'nullable|string|max:100',
        'short_description_fr' => 'nullable|string',
        'full_description_fr'  => 'nullable|string',
    ]);

    Formation::create([
        'title_fr'             => $request->title_fr,
        'email'                => Auth::user()->email,
        'level'                => $request->level ?? 'Beginner',
        'duration'             => $request->duration,
        'short_description_fr' => $request->short_description_fr,
        'full_description_fr'  => $request->full_description_fr,
    ]);

    return redirect('addformation')->with('success', __('messages.formations.createdSuccess'));
}


// delete post 
public function destroy($id){
    $this->authorize('manage formations');

    $formation = Formation::findOrFail($id);
    $formation->delete();
    return redirect('addformation');
}

// logout
public function logout(){
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
}

// language
public function setLanguage($locale){
    if (in_array($locale, ['en', 'fr'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
}
}
