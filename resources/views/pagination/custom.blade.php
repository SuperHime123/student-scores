@if ($paginator->hasPages())
    <div class="pagination">
        <div class="pagination-container">
            <!-- Previous Button -->
            @if ($paginator->onFirstPage())
                <button class="pagination-btn disabled" disabled>上一页</button>
            @else
                <a href="{{ $paginator->appends(request()->query())->previousPageUrl() }}" class="pagination-btn">上一页</a>
            @endif

            <!-- Page Numbers -->
            <div class="page-numbers">
                @foreach ($paginator->appends(request()->query())->getUrlRange(1, $paginator->lastPage()) as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <button class="pagination-btn active">{{ $page }}</button>
                    @else
                        <a href="{{ $url }}" class="pagination-btn">{{ $page }}</a>
                    @endif
                @endforeach
            </div>

            <!-- Next Button -->
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->appends(request()->query())->nextPageUrl() }}" class="pagination-btn">下一页</a>
            @else
                <button class="pagination-btn disabled" disabled>下一页</button>
            @endif
        </div>
    </div>
@endif
