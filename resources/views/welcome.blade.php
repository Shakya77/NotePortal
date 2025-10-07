<x-guest-layout>
    <!-- Hero Section -->
    <section class="hero-pattern pt-24 pb-12">
        <div class="max-w-screen-xl mx-auto px-4 py-12">
            <div class="text-center mb-12">
                <h1 class="text-5xl font-bold text-gray-900 mb-4">Learn to Code</h1>
                <p class="text-xl text-gray-600 mb-8">With the world's largest web developer site.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="tutorials.html"
                        class="px-8 py-3 bg-green-600 text-white font-semibold rounded hover:bg-green-700 transition">Start
                        Learning</a>
                    <a href="exercises.html"
                        class="px-8 py-3 bg-yellow-400 text-gray-900 font-semibold rounded hover:bg-yellow-500 transition">Try
                        Exercises</a>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="max-w-2xl mx-auto mb-12">
                <form class="flex items-center">
                    <label for="search" class="sr-only">Search</label>
                    <div class="relative w-full">
                        <input type="text" id="search"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-4"
                            placeholder="Search our tutorials, e.g. HTML" required>
                        <button type="submit"
                            class="absolute right-2.5 top-2.5 px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300">
                            Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Popular Tutorials Section -->
    <section class="py-12 bg-white">
        <div class="max-w-screen-xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($topics as $topic)
                    <a href="{{ route('default', $topic->slug) }}"
                        class="tutorial-card block p-6 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                        <div class="flex items-center mb-4">
                            <h3 class="text-3xl font-bold text-gray-900">{{ $topic->title }}</h3>
                        </div>
                        <p class="text-gray-600">{{ $topic->description }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

</x-guest-layout>
