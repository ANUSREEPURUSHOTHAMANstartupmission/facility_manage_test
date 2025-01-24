{{-- <tfoot>
    <tr{{ html_classes($table->getTrClasses()) }}>
        <td{{ html_classes('bg-light', $table->getTdClasses()) }}{{ html_attributes($table->getColumnsCount() > 1 ? ['colspan' => $table->getColumnsCount()] : null) }}>
            <div class="d-flex justify-content-between flex-wrap">
                @include('laravel-table::' . $table->getNavigationStatusTemplatePath())
                @include('laravel-table::' . $table->getPaginationTemplatePath())
            </div>
        </td>
    </tr>
</tfoot> --}}

<div class="d-flex justify-content-between pb-3">
    <div class="text-muted">
        @include('laravel-table::' . $table->getNavigationStatusTemplatePath())
    </div>
    @include('laravel-table::' . $table->getPaginationTemplatePath())
</div>