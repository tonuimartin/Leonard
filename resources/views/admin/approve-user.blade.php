<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve User - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    User Approval Required
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Please review the user details below and approve their access
                </p>
            </div>
            
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <p class="mt-1 text-sm text-gray-900 bg-gray-50 px-3 py-2 rounded">{{ $user->name }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <p class="mt-1 text-sm text-gray-900 bg-gray-50 px-3 py-2 rounded">{{ $user->email }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <p class="mt-1 text-sm text-gray-900 bg-gray-50 px-3 py-2 rounded">{{ $user->phone_number ?? 'Not provided' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Registration Date</label>
                        <p class="mt-1 text-sm text-gray-900 bg-gray-50 px-3 py-2 rounded">{{ $user->created_at->format('F j, Y \a\t g:i A') }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email Verification Status</label>
                        <p class="mt-1 text-sm bg-gray-50 px-3 py-2 rounded">
                            @if($user->hasVerifiedEmail())
                                <span class="text-green-600 font-medium">✓ Email Verified</span>
                            @else
                                <span class="text-red-600 font-medium">✗ Email Not Verified</span>
                            @endif
                        </p>
                    </div>
                </div>
                
                <div class="mt-6 flex space-x-4">
                    <form method="POST" action="{{ route('admin.approve-user.confirm', ['token' => $token, 'user' => $user->id]) }}" class="flex-1">
                        @csrf
                        <button type="submit" 
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                            Approve User
                        </button>
                    </form>
                    
                    <button onclick="window.close()" 
                            class="flex-1 flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        Cancel
                    </button>
                </div>
                
                <div class="mt-4 text-center text-xs text-gray-500">
                    This approval link is secure and can only be used once.
                </div>
            </div>
        </div>
    </div>
</body>
</html>
