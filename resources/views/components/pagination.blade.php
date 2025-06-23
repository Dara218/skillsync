@if ($paginator->hasPages())
  <div class="pagination-container">
    <ol class="pagination">
      {{-- First Page Link --}}
      @if ($paginator->onFirstPage())
        <span class="pagination__link pagination__link--disabled"><</span>
      @else
        <a class="pagination__link" href="{{ $paginator->url(1) }}"><</a>
      @endif

      {{-- Pagination Elements --}}
      @php
        $start = max($paginator->currentPage() - 4, 1);
        $end = min($start + 9, $paginator->lastPage());
        $start = max($end - 9, 1);
      @endphp

      @for ($i = $start; $i <= $end; $i++)
        @if ($i == $paginator->currentPage())
          <span class="pagination__link pagination__link--active"><b>{{ $i }}</b></span>
        @else
          <a class="pagination__link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
        @endif
      @endfor

      {{-- Last Page Link --}}
      @if ($paginator->currentPage() == $paginator->lastPage())
        <span class="pagination__link pagination__link--disabled">></span>
      @else
        <a class="pagination__link" href="{{ $paginator->url($paginator->lastPage()) }}">></a>
      @endif
    </ol>
  </div>
@endif