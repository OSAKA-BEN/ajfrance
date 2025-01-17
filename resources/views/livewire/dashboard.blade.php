<main class="main-content">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-xl-6 mb-xl-0 mb-4">
                        <div class="card bg-transparent shadow-xl">
                            <div class="overflow-hidden position-relative border-radius-xl"
                                style="background-image: url('../assets/img/curved-images/curved14.jpg');">
                                <span class="mask bg-gradient-dark"></span>
                                <div class="card-body position-relative z-index-1 p-3">
                                    <i class="fas fa-wifi text-white p-2"></i>
                                    <h2 class="text-white mt-2 mb-3 pb-2 text-xxl">
                                        {{ $user->name }}</h2>
                                    <div class="d-flex">
                                        <div class="d-flex">
                                            <div class="me-4">
                                                <p class="text-white text-sm opacity-8 mb-0">Email Address</p>
                                                <h6 class="text-white mb-0">{{ $user->email }}</h6>
                                            </div>
                                        </div>
                                        <div class="ms-auto w-20 d-flex align-items-end justify-content-end">
                                            @if ($user->profile_image)
                                                <img class="w-100 mt-2 rounded-circle" src="{{ asset('storage/' . $user->profile_image) }}" alt="profile picture">
                                            @else
                                                <img class="w-100 mt-2 rounded-circle" src="{{ '../assets/img/avatar-placeholder-none.png' }}" alt="profile picture">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="row">
                            @if($user->isAdmin())
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <h1 class="text-gradient text-warning">
                                                <span id="status1" countto="{{ $totalLessons }}">{{ $totalLessons }}</span>
                                            </h1>
                                            <h6 class="mb-0 font-weight-bolder">Lessons</h6>
                                            <p class="opacity-8 mb-0 text-sm">{{ __('Total Lessons') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <h1 class="text-gradient text-warning">
                                                <span id="status2" countto="{{ $studentStats['count'] }}">{{ $studentStats['count'] }}</span>
                                            </h1>
                                            <h6 class="mb-0 font-weight-bolder">Students</h6>
                                            <p class="opacity-8 mb-0 text-sm">Total Credits: {{ $studentStats['total_credits'] }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <h1 class="text-gradient text-warning">
                                                <span id="status3" countto="{{ $guestStats['count'] }}">{{ $guestStats['count'] }}</span>
                                            </h1>
                                            <h6 class="mb-0 font-weight-bolder">Guests</h6>
                                            <p class="opacity-8 mb-0 text-sm">Total Credits: {{ $guestStats['total_credits'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            @else
                            @if(!$user->isTeacher())
                                <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <h1 class="text-gradient text-warning">
                                                    <span id="status1" countto="{{ $user->credits }}">{{ $user->credits }}</span>
                                                </h1>
                                                <h6 class="mb-0 font-weight-bolder">Credits</h6>
                                                <p class="opacity-8 mb-0 text-sm">nombre de crédits disponibles</p>
                                            </div>
                                        </div>
                                    </div>
                                 @endif
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <h1 class="text-gradient text-warning">
                                                <span id="status2" countto="{{ $completedLessonsCount }}">{{ $completedLessonsCount }}</span>
                                            </h1>
                                            <h6 class="mb-0 font-weight-bolder">Lessons</h6>
                                            <p class="opacity-8 mb-0 text-sm">nombre de leçons complétées</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12 mt-4">
                        <div class="card">
                            <div class="card-header pb-0 px-3">
                                <h6 class="mb-0">Lessons History</h6>
                            </div>
                            <div class="card-body pt-4 p-3">
                                <ul class="list-group">
                                    @forelse($user->isAdmin() ? $recentLessons : $lessonHistory as $lesson)
                                        <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                            <div class="d-flex flex-column">
                                                @if($user->isAdmin())
                                                    <h6 class="mb-3 text-sm">Teacher: {{ $lesson->teacher->name }} | Student: {{ $lesson->student->name }}</h6>
                                                @elseif($user->isTeacher())
                                                    <h6 class="mb-3 text-sm">Student: {{ $lesson->student->name }}</h6>
                                                @else
                                                    <h6 class="mb-3 text-sm">Teacher: {{ $lesson->teacher->name }}</h6>
                                                @endif
                                                <span class="mb-2 text-xs">Lesson Date : <span
                                                        class="text-dark font-weight-bold ms-2">
                                                        {{ $lesson->formatted_start_datetime }}
                                                    </span></span>
                                                <span class="mb-2 text-xs">Type : <span
                                                        class="text-dark ms-2 font-weight-bold">{{ $lesson->lesson_type }}</span></span>
                                            </div>
                                            <div class="ms-auto">
                                                @if($lesson->status === 'cancelled')
                                                    <span class="btn btn-link text-danger text-gradient px-3 mb-0">
                                                        <i class="far fa-trash-alt me-2"></i>Cancelled
                                                    </span>
                                                @elseif($lesson->status === 'completed')
                                                    <span class="btn btn-link text-success text-gradient px-3 mb-0">
                                                        <i class="fas fa-check me-2"></i>Completed
                                                    </span>
                                                @else
                                                    <span class="btn btn-link text-info text-gradient px-3 mb-0">
                                                        <i class="fas fa-clock me-2"></i>Reserved
                                                    </span>
                                                @endif
                                            </div>
                                        </li>
                                    @empty
                                        <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-3 text-sm">No lesson found</h6>
                                            </div>
                                        </li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


<script src="../../assets/js/plugins/countup.min.js"></script>
<script>
// Count To
if (document.getElementById('status1')) {
    const countUp = new CountUp('status1', document.getElementById("status1").getAttribute("countTo"));
    if (!countUp.error) {
        countUp.start();
    } else {
        console.error(countUp.error);
    }
}
if (document.getElementById('status2')) {
    const countUp = new CountUp('status2', document.getElementById("status2").getAttribute("countTo"));
    if (!countUp.error) {
        countUp.start();
    } else {
        console.error(countUp.error);
    }
}
if (document.getElementById('status3')) {
    const countUp = new CountUp('status3', document.getElementById("status3").getAttribute("countTo"));
    if (!countUp.error) {
        countUp.start();
    } else {
        console.error(countUp.error);
    }
}
if (document.getElementById('status4')) {
    const countUp = new CountUp('status4', document.getElementById("status4").getAttribute("countTo"));
    if (!countUp.error) {
      countUp.start();
    } else {
      console.error(countUp.error);
    }
  }
  if (document.getElementById('status5')) {
    const countUp = new CountUp('status5', document.getElementById("status5").getAttribute("countTo"));
    if (!countUp.error) {
      countUp.start();
    } else {
      console.error(countUp.error);
    }
  }
  if (document.getElementById('status6')) {
    const countUp = new CountUp('status6', document.getElementById("status6").getAttribute("countTo"));
    if (!countUp.error) {
      countUp.start();
    } else {
      console.error(countUp.error);
    }
  }
</script>