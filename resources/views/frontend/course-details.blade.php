@extends('layouts.lms')

@section('title', $course->title . ' | Loksewa LMS')
@section('header', 'Course Details')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Feedback Alerts -->
    @if(session('success'))
        <div class="mb-8 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center gap-3 animate-pulse">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            <span class="font-bold text-sm">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-xs font-medium text-gray-400 mb-8">
        <a href="{{ url('/catalog') }}" class="hover:text-emerald-600 transition-colors">Catalog</a>
        <i data-lucide="chevron-right" class="w-3 h-3"></i>
        <span class="text-gray-900">{{ $course->title }}</span>
    </nav>

    <div class="flex flex-col lg:flex-row gap-12">
        <!-- Left: Course Info & Content -->
        <div class="flex-1 min-w-0">
            <div class="mb-10">
                <h1 class="text-4xl font-black text-gray-900 mb-6 tracking-tight leading-tight">{{ $course->title }}</h1>
                <p class="text-lg text-gray-500 leading-relaxed mb-8 max-w-2xl">{{ $course->description }}</p>
                
                <div class="flex flex-wrap gap-8 py-8 border-y border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-emerald-600">
                            <i data-lucide="book-open" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase">Modules</p>
                            <p class="text-sm font-bold text-gray-900">{{ $course->modules->count() }} Chapters</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-emerald-600">
                            <i data-lucide="users" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase">Status</p>
                            <p class="text-sm font-bold text-gray-900">Open Access</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-emerald-600">
                            <i data-lucide="shield-check" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase">Verification</p>
                            <p class="text-sm font-bold text-gray-900">Verified Path</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Syllabus Section -->
            <div class="mb-12">
                <div class="flex items-center justify-between mb-8">
                    <h4 class="text-xl font-bold text-gray-900">Preparation Curriculum</h4>
                    @auth
                    @if(Auth::user()->hasRole('admin'))
                        <button onclick="toggleModuleBuilder()" class="text-sm font-bold text-emerald-600 px-4 py-2 bg-emerald-50 rounded-lg hover:bg-emerald-100">+ Add Module</button>
                    @endif
                    @endauth
                </div>

                @auth
                @if(Auth::user()->hasRole('admin'))
                    <div id="module-builder" class="hidden mb-6 p-4 border border-emerald-200 rounded-2xl bg-emerald-50">
                        <form method="POST" action="{{ route('admin.modules.add', $course) }}">
                            @csrf
                            <label class="block text-sm font-bold text-emerald-800 mb-2">New Module Title</label>
                            <div class="flex gap-2">
                                <input type="text" name="title" required class="flex-1 px-4 py-2 border rounded-lg" placeholder="e.g., Introduction to History" />
                                <button type="submit" class="px-6 py-2 bg-emerald-600 text-white rounded-lg font-bold">Save</button>
                            </div>
                        </form>
                    </div>
                @endif
                @endauth

                <div class="space-y-4">
                    @forelse($course->modules as $index => $module)
                        @auth
                        @if(Auth::user()->hasRole('admin'))
                            <!-- Add Chapter Form (hidden) -->
                            <div id="chapter-form-{{ $module->id }}" class="hidden mt-2 p-3 border border-gray-200 rounded bg-gray-50">
                                <form method="POST" action="{{ route('admin.chapters.add', $module) }}">
                                    @csrf
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Chapter Title</label>
                                            <input type="text" name="title" required class="w-full px-3 py-2 border rounded" placeholder="e.g., Geography and History" />
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Order (optional)</label>
                                            <input type="number" name="order" class="w-full px-3 py-2 border rounded" placeholder="1" />
                                        </div>
                                    </div>
                                    <button type="submit" class="mt-2 px-4 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700">Add Chapter</button>
                                </form>
                            </div>
                            <button onclick="toggleChapterBuilder({{ $module->id }})" class="mt-1 text-sm text-emerald-600 hover:underline">+ Add Chapter</button>
                        @endif
                        @endauth
                        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
                            <button class="w-full flex items-center justify-between p-6 text-left hover:bg-gray-50 transition-colors" onclick="toggleModule({{ $module->id }})">
                                <span class="flex items-center gap-4">
                                    <span class="w-8 h-8 rounded-lg bg-gray-900 text-white flex items-center justify-center text-xs font-bold">{{ $index + 1 }}</span>
                                    <span class="font-bold text-gray-900">{{ $module->title }}</span>
                                </span>
                                <i data-lucide="chevron-down" id="icon-{{ $module->id }}" class="w-4 h-4 text-gray-400 transition-transform"></i>
                            </button>
                            <div id="module-{{ $module->id }}" class="hidden px-6 pb-6 pt-2 border-t border-gray-50 bg-gray-50/30">
                                @foreach($module->chapters as $chapter)
                                @auth
                                @if(Auth::user()->hasRole('admin'))
                                    <!-- Add Lesson Form (hidden) -->
                                    <div id="lesson-form-{{ $chapter->id }}" class="hidden mt-2 p-3 border border-gray-200 rounded bg-gray-50">
                                        <form method="POST" action="{{ route('admin.lessons.add', $chapter) }}">
                                            @csrf
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Lesson Title</label>
                                                    <input type="text" name="title" required class="w-full px-3 py-2 border rounded" placeholder="e.g., Physical Geography" />
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                                                    <select name="type" class="w-full px-3 py-2 border rounded" required>
                                                        <option value="text">Text</option>
                                                        <option value="video">Video</option>
                                                        <option value="pdf">PDF</option>
                                                        <option value="quiz">Quiz</option>
                                                    </select>
                                                </div>
                                                <div class="col-span-2">
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Content / Attachment Path</label>
                                                    <textarea name="content" rows="3" class="w-full px-3 py-2 border rounded" placeholder="Enter text or JSON for quiz, or leave empty for PDF path."></textarea>
                                                </div>
                                            </div>
                                            <button type="submit" class="mt-2 px-4 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700">Add Lesson</button>
                                        </form>
                                    </div>
                                    <button onclick="toggleLessonForm({{ $chapter->id }})" class="mt-1 text-sm text-emerald-600 hover:underline">+ Add Lesson</button>
                                @endif
                                @endauth
                                    <div class="mt-4">
                                        <h6 class="text-[10px] font-black uppercase tracking-widest text-emerald-600 mb-3">{{ $chapter->title }}</h6>
                                        <div class="space-y-2">
                                            @foreach($chapter->lessons as $lesson)
                                                <div class="flex items-center justify-between p-3 rounded-xl bg-white border border-gray-100 group">
                                                    <div class="flex items-center gap-3">
                                                        <i data-lucide="{{ $lesson->type == 'video' ? 'play-circle' : 'file-text' }}" class="w-4 h-4 text-gray-400"></i>
                                                        <span class="text-sm font-medium text-gray-700">{{ $lesson->title }}</span>
                                                    </div>
                                                    @if($isEnrolled)
                                                        <a href="{{ route('lessons.show', [$course->slug, $lesson->slug]) }}" class="text-[10px] font-bold text-emerald-600 uppercase hover:underline">Start Lesson</a>
                                                    @else
                                                        <i data-lucide="lock" class="w-3 h-3 text-gray-300"></i>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="p-10 text-center bg-gray-50 border-2 border-dashed border-gray-200 rounded-3xl">
                            <i data-lucide="calendar" class="w-10 h-10 text-gray-300 mx-auto mb-4"></i>
                            <p class="text-gray-500 font-medium text-sm">Preparation curriculum is currently being updated for {{ $course->title }}. Check back soon!</p>
                        </div>
                    @endforelse
                </div>

                                @auth
                @if($isEnrolled && $progressPercentage == 100 && $nextRecommendations->isNotEmpty())
                <div class="mt-8 p-6 bg-emerald-50 border border-emerald-200 rounded-xl">
                    <h4 class="text-xl font-bold text-gray-900 mb-4">Collaborative Recommendations</h4>
                    <ul class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($nextRecommendations as $rec)
                        <li class="flex items-center">
                            <a href="{{ url('/courses/' . $rec->slug) }}" class="text-emerald-600 hover:underline font-medium">
                                {{ $rec->title }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @endauth

            </div>

            <!-- Related Courses (Algorithm 2) -->
            <div>
                <h4 class="text-xl font-bold text-gray-900 mb-8">Related Preparation Materials</h4>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    @foreach($relatedCourses as $rel)
                        <a href="{{ url('/courses/' . $rel->slug) }}" class="group block">
                            <div class="aspect-video rounded-xl overflow-hidden mb-3">
                                @if($rel->thumbnail)
                                    <img src="{{ Str::startsWith($rel->thumbnail, 'http') ? $rel->thumbnail : Storage::url($rel->thumbnail) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $rel->title }}">
                                @else
                                    <div class="w-full h-full bg-emerald-50 text-emerald-700 flex items-center justify-center font-black text-3xl">
                                        {{ strtoupper(substr($rel->title, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <h6 class="font-bold text-gray-900 group-hover:text-emerald-600 transition-colors leading-tight">{{ $rel->title }}</h6>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right: Action Card -->
        <div class="lg:w-96">
            <div class="bg-white rounded-3xl border border-gray-200 p-8 shadow-2xl shadow-gray-100 sticky top-12">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-black text-emerald-600 mb-1">Free Access</h2>
                    <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">Public Learning Resource</p>
                </div>

                @if($isEnrolled)
                    <div class="space-y-4">
                        <div class="bg-emerald-50 p-5 rounded-2xl border border-emerald-100 text-center">
                            <p class="text-emerald-800 font-bold text-sm mb-2">You are Enrolled!</p>
                            <div class="flex items-center justify-between text-xs font-bold text-emerald-700 mb-1">
                                <span>Course Progress</span>
                                <span>{{ $progressPercentage ?? 0 }}%</span>
                            </div>
                            <div class="w-full bg-emerald-200/50 h-2 rounded-full overflow-hidden mb-3">
                                <div class="bg-emerald-600 h-full transition-all duration-1000" style="width: {{ $progressPercentage ?? 0 }}%"></div>
                            </div>
                            <p class="text-emerald-600 text-[10px] font-medium uppercase tracking-wider">
                                {{ ($progressPercentage ?? 0) >= 100 ? 'Course Completed' : 'Preparation in progress' }}
                            </p>
                        </div>
                        @php 
                            $firstLesson = $course->modules->first()?->chapters->first()?->lessons->first();
                        @endphp
                        @if($firstLesson)
                            <a href="{{ route('lessons.show', [$course->slug, $firstLesson->slug]) }}" class="w-full block text-center bg-gray-900 hover:bg-black text-white py-4 rounded-2xl font-bold text-lg transition-all shadow-xl">
                                Resume Learning
                            </a>
                        @else
                            <div class="bg-gray-50 p-4 rounded-2xl text-center text-xs text-gray-400 italic">No lessons available yet.</div>
                        @endif

                        <form action="{{ route('courses.unenroll', $course->id) }}" method="POST" class="mt-4">
                            @csrf
                            <button type="submit" class="w-full text-center text-red-500 hover:text-red-700 text-xs font-bold uppercase tracking-widest transition-colors">
                                Unenroll from this course
                            </button>
                        </form>
                    </div>
                @else
                    <form action="{{ route('courses.enroll', $course->id) }}" method="POST">
                        @csrf
                        <button class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-4 rounded-2xl font-bold text-lg transition-all shadow-xl shadow-emerald-100 mb-6">
                            Start Preparation Now
                        </button>
                    </form>
                @endif

                <div class="space-y-4 pt-8 mt-8 border-t border-gray-100">
                    <h6 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">This path includes:</h6>
                    <div class="flex items-center gap-3 text-sm font-semibold text-gray-600">
                        <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-500"></i>
                        Full curriculum access
                    </div>
                    <div class="flex items-center gap-3 text-sm font-semibold text-gray-600">
                        <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-500"></i>
                        Downloadable materials
                    </div>
                    <div class="flex items-center gap-3 text-sm font-semibold text-gray-600">
                        <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-500"></i>
                        Lifetime expert support
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleModule(id) {
        const module = document.getElementById('module-' + id);
        const icon = document.getElementById('icon-' + id);
        module.classList.toggle('hidden');
        icon.classList.toggle('rotate-180');
    }
    function toggleModuleBuilder() {
        const el = document.getElementById('module-builder');
        if (el) el.classList.toggle('hidden');
    }
    function toggleChapterBuilder(moduleId) {
        const el = document.getElementById(`chapter-form-${moduleId}`);
        if (el) el.classList.toggle('hidden');
    }
    function toggleLessonForm(chapterId) {
        const el = document.getElementById(`lesson-form-${chapterId}`);
        if (el) el.classList.toggle('hidden');
    }
</script>
@endsection
