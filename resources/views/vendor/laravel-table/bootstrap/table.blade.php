<div class="card">
    <div {{ html_classes('table-responsive') }}>
        <table {{ html_attributes($table->getIdentifier() ? ['id' => $table->getIdentifier()] : null) }}{{ html_classes('table', $table->getTableClasses()) }}>
            @include('laravel-table::' . $table->getTheadTemplatePath())
            @include('laravel-table::' . $table->getTbodyTemplatePath())
        </table>
    </div>
    @include('laravel-table::' . $table->getTfootTemplatePath())

</div>
