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
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Popular Tutorials</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- HTML Tutorial Card -->
                <a href="tutorial-detail.html?lang=html"
                    class="tutorial-card block p-6 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <div class="flex items-center mb-4">
                        <div
                            class="w-12 h-12 bg-orange-500 rounded flex items-center justify-center text-white font-bold text-xl">
                            H
                        </div>
                        <h3 class="ml-3 text-xl font-bold text-gray-900">HTML</h3>
                    </div>
                    <p class="text-gray-600 mb-4">The language for building web pages</p>
                    <span class="text-green-600 font-semibold">Learn HTML →</span>
                </a>

                <!-- CSS Tutorial Card -->
                <a href="tutorial-detail.html?lang=css"
                    class="tutorial-card block p-6 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <div class="flex items-center mb-4">
                        <div
                            class="w-12 h-12 bg-blue-500 rounded flex items-center justify-center text-white font-bold text-xl">
                            C
                        </div>
                        <h3 class="ml-3 text-xl font-bold text-gray-900">CSS</h3>
                    </div>
                    <p class="text-gray-600 mb-4">The language for styling web pages</p>
                    <span class="text-green-600 font-semibold">Learn CSS →</span>
                </a>

                <!-- JavaScript Tutorial Card -->
                <a href="tutorial-detail.html?lang=javascript"
                    class="tutorial-card block p-6 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <div class="flex items-center mb-4">
                        <div
                            class="w-12 h-12 bg-yellow-400 rounded flex items-center justify-center text-gray-900 font-bold text-xl">
                            JS
                        </div>
                        <h3 class="ml-3 text-xl font-bold text-gray-900">JavaScript</h3>
                    </div>
                    <p class="text-gray-600 mb-4">The language for programming web pages</p>
                    <span class="text-green-600 font-semibold">Learn JavaScript →</span>
                </a>

                <!-- Python Tutorial Card -->
                <a href="tutorial-detail.html?lang=python"
                    class="tutorial-card block p-6 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <div class="flex items-center mb-4">
                        <div
                            class="w-12 h-12 bg-blue-600 rounded flex items-center justify-center text-white font-bold text-xl">
                            Py
                        </div>
                        <h3 class="ml-3 text-xl font-bold text-gray-900">Python</h3>
                    </div>
                    <p class="text-gray-600 mb-4">A popular programming language</p>
                    <span class="text-green-600 font-semibold">Learn Python →</span>
                </a>

                <!-- SQL Tutorial Card -->
                <a href="tutorial-detail.html?lang=sql"
                    class="tutorial-card block p-6 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <div class="flex items-center mb-4">
                        <div
                            class="w-12 h-12 bg-indigo-600 rounded flex items-center justify-center text-white font-bold text-xl">
                            SQL
                        </div>
                        <h3 class="ml-3 text-xl font-bold text-gray-900">SQL</h3>
                    </div>
                    <p class="text-gray-600 mb-4">A language for accessing databases</p>
                    <span class="text-green-600 font-semibold">Learn SQL →</span>
                </a>

                <!-- PHP Tutorial Card -->
                <a href="tutorial-detail.html?lang=php"
                    class="tutorial-card block p-6 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <div class="flex items-center mb-4">
                        <div
                            class="w-12 h-12 bg-purple-600 rounded flex items-center justify-center text-white font-bold text-xl">
                            PHP
                        </div>
                        <h3 class="ml-3 text-xl font-bold text-gray-900">PHP</h3>
                    </div>
                    <p class="text-gray-600 mb-4">A web server programming language</p>
                    <span class="text-green-600 font-semibold">Learn PHP →</span>
                </a>

                <!-- Java Tutorial Card -->
                <a href="tutorial-detail.html?lang=java"
                    class="tutorial-card block p-6 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <div class="flex items-center mb-4">
                        <div
                            class="w-12 h-12 bg-red-600 rounded flex items-center justify-center text-white font-bold text-xl">
                            J
                        </div>
                        <h3 class="ml-3 text-xl font-bold text-gray-900">Java</h3>
                    </div>
                    <p class="text-gray-600 mb-4">A popular programming language</p>
                    <span class="text-green-600 font-semibold">Learn Java →</span>
                </a>

                <!-- C++ Tutorial Card -->
                <a href="tutorial-detail.html?lang=cpp"
                    class="tutorial-card block p-6 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <div class="flex items-center mb-4">
                        <div
                            class="w-12 h-12 bg-pink-600 rounded flex items-center justify-center text-white font-bold text-xl">
                            C++
                        </div>
                        <h3 class="ml-3 text-xl font-bold text-gray-900">C++</h3>
                    </div>
                    <p class="text-gray-600 mb-4">A powerful programming language</p>
                    <span class="text-green-600 font-semibold">Learn C++ →</span>
                </a>
            </div>
        </div>
    </section>

</x-guest-layout>
