<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approval Error - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Approval Error
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    There was an issue with the approval process
                </p>
            </div>
            
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="bg-red-50 border border-red-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">
                                Unable to Process Approval
                            </h3>
                            <div class="mt-2 text-sm text-red-700">
                                <p>{{ $message ?? session('error') ?? 'An error occurred while processing the approval.' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 space-y-4">
                    <div class="text-sm text-gray-600">
                        <p><strong>Possible reasons:</strong></p>
                        <ul class="mt-2 list-disc list-inside space-y-1">
                            <li>The approval link has expired</li>
                            <li>The user has already been approved</li>
                            <li>The user hasn't verified their email yet</li>
                            <li>Invalid approval token</li>
                        </ul>
                    </div>
                    
                    <div class="text-sm text-gray-600">
                        <p><strong>What to do next:</strong></p>
                        <ul class="mt-2 list-disc list-inside space-y-1">
                            <li>Contact the system administrator</li>
                            <li>Check if the user has verified their email</li>
                            <li>Request a new approval link if needed</li>
                        </ul>
                    </div>
                </div>
                
                <div class="mt-6">
                    <button onclick="window.close()" 
                            class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        Close Window
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
