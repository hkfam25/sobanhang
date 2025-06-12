@if ($crud->hasAccess('create'))
    <a href="{{ url($crud->route.'/create') }}" class="btn btn-primary" bp-button="create" data-style="zoom-in">
        <i class="la la-plus"></i> <span>{{ 'Thêm' }}</span>
    </a>
@endif