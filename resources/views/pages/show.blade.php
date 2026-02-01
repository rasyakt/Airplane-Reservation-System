<x-app-layout>
    <div class="container mx-auto px-6 py-20">
        <div class="max-w-4xl mx-auto">
            <div class="card p-10">
                <div class="flex items-center gap-4 mb-8">
                    <div
                        class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center text-primary-600">
                        <i class="{{ $page['icon'] }} text-3xl"></i>
                    </div>
                    <h1 class="text-4xl font-bold text-gray-900">{{ $page['title'] }}</h1>
                </div>

                <div class="prose max-w-none text-gray-600 text-lg leading-relaxed whitespace-pre-line">
                    {{ $page['content'] }}
                </div>
            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('home') }}" class="text-primary-600 font-semibold hover:underline">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Home
                </a>
            </div>
        </div>
    </div>
</x-app-layout>