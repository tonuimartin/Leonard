<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Approved - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    User Approved Successfully
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    The user has been notified and can now access the system
                </p>
            </div>
            
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="space-y-4">
                    <div class="bg-green-50 border border-green-200 rounded-md p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-green-800">
                                    Approval Completed
                                </h3>
                                <div class="mt-2 text-sm text-green-700">
                                    <p><strong>{{ $user->name }}</strong> has been approved and notified via email.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">User:</span>
                            <span class="text-gray-900 font-medium">{{ $user->name }}</span>
                        </div>
                        
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Email:</span>
                            <span class="text-gray-900 font-medium">{{ $user->email }}</span>
                        </div>
                        
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Approved by:</span>
                            <span class="text-gray-900 font-medium">{{ $admin }}</span>
                        </div>
                        
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Approval time:</span>
                            <span class="text-gray-900 font-medium">
                                {{ $user->admin_approved_at ? $user->admin_approved_at->format('F j, Y \a\t g:i A') : 'N/A' }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6">
                    <button onclick="window.close()" 
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        Close Window
                    </button>
                </div>
                
                <div class="mt-4 text-center text-xs text-gray-500">
                    The user will receive an email confirmation and can now log in to the system.
                </div>
            </div>
        </div>
    </div>
</body>
</html>
