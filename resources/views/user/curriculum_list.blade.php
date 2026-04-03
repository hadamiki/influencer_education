@extends('user.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/curriculum_list.css') }}">
@endsection

@section('content')
<div class="page">

    <div class="top-nav">
        <div class="top-nav-left">
            <a href="{{ route('user.show.curriculum', ['year' => $year, 'month' => $month]) }}" class="top-nav-button is-active">時間割</a>
            <a href="#" class="top-nav-button">授業進捗</a>
            <a href="#" class="top-nav-button">プロフィール設定</a>
        </div>

        <div class="top-nav-right">
            <a href="#" class="logout-link">ログアウト</a>
        </div>
    </div>

    <div class="schedule-header">
        <a href="{{ route('user.show.top') }}" class="schedule-back">← 戻る</a>

        <div class="schedule-header-row">
            <div class="schedule-month-area">
                <a href="{{ route('user.show.curriculum', array_filter([
                    'grade_id' => $selectedGradeId,
                    'year' => $prevMonth->year,
                    'month' => $prevMonth->month,
                ])) }}"
                   class="month-arrow-link js-month-link"
                   data-year="{{ $prevMonth->year }}"
                   data-month="{{ $prevMonth->month }}">
                    <span class="month-arrow">◀</span>
                </a>

                <h1 class="schedule-title" id="schedule-title">{{ $year }}年{{ $month }}月スケジュール</h1>

                <a href="{{ route('user.show.curriculum', array_filter([
                    'grade_id' => $selectedGradeId,
                    'year' => $nextMonth->year,
                    'month' => $nextMonth->month,
                ])) }}"
                   class="month-arrow-link js-month-link"
                   data-year="{{ $nextMonth->year }}"
                   data-month="{{ $nextMonth->month }}">
                    <span class="month-arrow">▶</span>
                </a>
            </div>

            <div class="current-grade" id="current-grade-label">{{ $selectedGradeLabel }}</div>
        </div>
    </div>

    <div class="layout">
        <aside class="sidebar">
            <a href="{{ route('user.show.curriculum', ['grade_id' => 1, 'year' => $year, 'month' => $month]) }}"
               class="grade js-grade-link {{ (int) $selectedGradeId === 1 ? 'is-selected' : '' }}"
               data-grade-id="1">
                小学校1年生
            </a>

            <a href="{{ route('user.show.curriculum', ['grade_id' => 2, 'year' => $year, 'month' => $month]) }}"
               class="grade js-grade-link {{ (int) $selectedGradeId === 2 ? 'is-selected' : '' }}"
               data-grade-id="2">
                小学校2年生
            </a>

            <a href="{{ route('user.show.curriculum', ['grade_id' => 3, 'year' => $year, 'month' => $month]) }}"
               class="grade js-grade-link {{ (int) $selectedGradeId === 3 ? 'is-selected' : '' }}"
               data-grade-id="3">
                小学校3年生
            </a>

            <a href="{{ route('user.show.curriculum', ['grade_id' => 4, 'year' => $year, 'month' => $month]) }}"
               class="grade js-grade-link {{ (int) $selectedGradeId === 4 ? 'is-selected' : '' }}"
               data-grade-id="4">
                小学校4年生
            </a>

            <a href="{{ route('user.show.curriculum', ['grade_id' => 5, 'year' => $year, 'month' => $month]) }}"
               class="grade js-grade-link {{ (int) $selectedGradeId === 5 ? 'is-selected' : '' }}"
               data-grade-id="5">
                小学校5年生
            </a>

            <a href="{{ route('user.show.curriculum', ['grade_id' => 6, 'year' => $year, 'month' => $month]) }}"
               class="grade js-grade-link {{ (int) $selectedGradeId === 6 ? 'is-selected' : '' }}"
               data-grade-id="6">
                小学校6年生
            </a>

            <a href="{{ route('user.show.curriculum', ['grade_id' => 7, 'year' => $year, 'month' => $month]) }}"
               class="grade grade-middle js-grade-link {{ (int) $selectedGradeId === 7 ? 'is-selected' : '' }}"
               data-grade-id="7">
                中学校1年生
            </a>

            <a href="{{ route('user.show.curriculum', ['grade_id' => 8, 'year' => $year, 'month' => $month]) }}"
               class="grade grade-middle js-grade-link {{ (int) $selectedGradeId === 8 ? 'is-selected' : '' }}"
               data-grade-id="8">
                中学校2年生
            </a>

            <a href="{{ route('user.show.curriculum', ['grade_id' => 9, 'year' => $year, 'month' => $month]) }}"
               class="grade grade-middle js-grade-link {{ (int) $selectedGradeId === 9 ? 'is-selected' : '' }}"
               data-grade-id="9">
                中学校3年生
            </a>

            <a href="{{ route('user.show.curriculum', ['grade_id' => 10, 'year' => $year, 'month' => $month]) }}"
               class="grade grade-high js-grade-link {{ (int) $selectedGradeId === 10 ? 'is-selected' : '' }}"
               data-grade-id="10">
                高校1年生
            </a>

            <a href="{{ route('user.show.curriculum', ['grade_id' => 11, 'year' => $year, 'month' => $month]) }}"
               class="grade grade-high js-grade-link {{ (int) $selectedGradeId === 11 ? 'is-selected' : '' }}"
               data-grade-id="11">
                高校2年生
            </a>

            <a href="{{ route('user.show.curriculum', ['grade_id' => 12, 'year' => $year, 'month' => $month]) }}"
               class="grade grade-high js-grade-link {{ (int) $selectedGradeId === 12 ? 'is-selected' : '' }}"
               data-grade-id="12">
                高校3年生
            </a>
        </aside>

        <main class="content">
            <div id="curriculum-list-area">
                @if($curriculums->isEmpty())
                    <p class="empty-message">表示できる授業がありません</p>
                @else
                    <div class="grid">
                        @foreach($curriculums as $curriculum)
                            <div class="card">
                                <div class="thumb">
                                    @if(!empty($curriculum->thumbnail))
                                        <img src="{{ asset($curriculum->thumbnail) }}" alt="サムネイル">
                                    @else
                                        <div class="no-image">No Image</div>
                                    @endif
                                </div>

                                <div class="card-body">
                                    <p class="title">{{ $curriculum->title }}</p>

                                    <div class="schedule-lines">
                                        @if((int) $curriculum->alway_delivery_flg === 1)
                                            <p class="always">常時公開</p>
                                        @else
                                            @forelse($curriculum->deliveryTimes as $time)
                                                @if($time->delivery_from && $time->delivery_to)
                                                    <p>
                                                        {{ \Carbon\Carbon::parse($time->delivery_from)->format('n月j日 H:i') }}
                                                        ～
                                                        {{ \Carbon\Carbon::parse($time->delivery_to)->format('H:i') }}
                                                    </p>
                                                @endif
                                            @empty
                                                <p>配信予定なし</p>
                                            @endforelse
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </main>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let selectedGradeId = @json($selectedGradeId ? (int) $selectedGradeId : null);
    let currentYear = @json($year);
    let currentMonth = @json($month);

    const titleEl = document.getElementById('schedule-title');
    const gradeLabelEl = document.getElementById('current-grade-label');
    const listAreaEl = document.getElementById('curriculum-list-area');

    function buildUrl(path, gradeId, year, month) {
        const params = new URLSearchParams();

        if (gradeId) {
            params.set('grade_id', gradeId);
        }

        params.set('year', year);
        params.set('month', month);

        return `${path}?${params.toString()}`;
    }

    function escapeHtml(text) {
        if (text === null || text === undefined) {
            return '';
        }

        return String(text)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function renderCurriculums(curriculums) {
        if (!curriculums || curriculums.length === 0) {
            listAreaEl.innerHTML = '<p class="empty-message">表示できる授業がありません</p>';
            return;
        }

        let html = '<div class="grid">';

        curriculums.forEach(function (curriculum) {
            html += '<div class="card">';
            html += '<div class="thumb">';

            if (curriculum.thumbnail) {
                html += `<img src="${escapeHtml(curriculum.thumbnail)}" alt="サムネイル">`;
            } else {
                html += '<div class="no-image">No Image</div>';
            }

            html += '</div>';
            html += '<div class="card-body">';
            html += `<p class="title">${escapeHtml(curriculum.title)}</p>`;
            html += '<div class="schedule-lines">';

            if (curriculum.is_always) {
                html += '<p class="always">常時公開</p>';
            } else if (curriculum.delivery_times && curriculum.delivery_times.length > 0) {
                curriculum.delivery_times.forEach(function (time) {
                    html += `<p>${escapeHtml(time.delivery_from)} ～ ${escapeHtml(time.delivery_to)}</p>`;
                });
            } else {
                html += '<p>配信予定なし</p>';
            }

            html += '</div>';
            html += '</div>';
            html += '</div>';
        });

        html += '</div>';

        listAreaEl.innerHTML = html;
    }

    function updateGradeHighlight() {
        document.querySelectorAll('.js-grade-link').forEach(function (el) {
            el.classList.remove('is-selected');

            if (String(el.dataset.gradeId) === String(selectedGradeId)) {
                el.classList.add('is-selected');
            }

            el.setAttribute('href', buildUrl('{{ route('user.show.curriculum') }}', el.dataset.gradeId, currentYear, currentMonth));
        });
    }

    function updateMonthLinks(prevYear, prevMonth, nextYear, nextMonth) {
        const monthLinks = document.querySelectorAll('.js-month-link');

        if (monthLinks.length < 2) {
            return;
        }

        monthLinks[0].dataset.year = prevYear;
        monthLinks[0].dataset.month = prevMonth;
        monthLinks[0].setAttribute('href', buildUrl('{{ route('user.show.curriculum') }}', selectedGradeId, prevYear, prevMonth));

        monthLinks[1].dataset.year = nextYear;
        monthLinks[1].dataset.month = nextMonth;
        monthLinks[1].setAttribute('href', buildUrl('{{ route('user.show.curriculum') }}', selectedGradeId, nextYear, nextMonth));
    }

    async function fetchCurriculumList(pushState = true) {
        const url = buildUrl('{{ route('user.show.curriculum') }}', selectedGradeId, currentYear, currentMonth);

        const response = await fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (!response.ok) {
            alert('データの取得に失敗しました。');
            return;
        }

        const data = await response.json();

        renderCurriculums(data.curriculums);
        titleEl.textContent = `${data.year}年${data.month}月スケジュール`;
        gradeLabelEl.textContent = data.selectedGradeLabel;

        currentYear = Number(data.year);
        currentMonth = Number(data.month);
        selectedGradeId = data.selectedGradeId ? Number(data.selectedGradeId) : null;

        updateGradeHighlight();
        updateMonthLinks(data.prevYear, data.prevMonth, data.nextYear, data.nextMonth);

        if (pushState) {
            const browserUrl = buildUrl('{{ route('user.show.curriculum') }}', selectedGradeId, currentYear, currentMonth);
            history.pushState({
                grade_id: selectedGradeId,
                year: currentYear,
                month: currentMonth
            }, '', browserUrl);
        }
    }

    document.querySelectorAll('.js-grade-link').forEach(function (el) {
        el.addEventListener('click', function (e) {
            e.preventDefault();
            selectedGradeId = Number(this.dataset.gradeId);
            fetchCurriculumList(true);
        });
    });

    document.querySelectorAll('.js-month-link').forEach(function (el) {
        el.addEventListener('click', function (e) {
            e.preventDefault();
            currentYear = Number(this.dataset.year);
            currentMonth = Number(this.dataset.month);
            fetchCurriculumList(true);
        });
    });

    window.addEventListener('popstate', function (event) {
        if (event.state) {
            selectedGradeId = event.state.grade_id ? Number(event.state.grade_id) : null;
            currentYear = Number(event.state.year);
            currentMonth = Number(event.state.month);
        } else {
            const params = new URLSearchParams(window.location.search);
            selectedGradeId = params.get('grade_id') ? Number(params.get('grade_id')) : null;
            currentYear = params.get('year') ? Number(params.get('year')) : @json($year);
            currentMonth = params.get('month') ? Number(params.get('month')) : @json($month);
        }

        fetchCurriculumList(false);
    });

    updateGradeHighlight();
});
</script>
@endsection