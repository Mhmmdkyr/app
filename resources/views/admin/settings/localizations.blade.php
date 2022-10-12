<div class="page-inner">
    <div class="page-header mb-0">
        <h4 class="page-title">{{ __('Languages') }}</h4>
        <a href="#edit-language" data-toggle="modal" class="btn btn-primary btn-border ml-auto add-new-lang"><i
                class="fas fa-plus"></i> {{ __('Add Language') }}</a>
    </div>
    <div class="row mb-2 mt-4">
        <div class="col-lg-8 col-md-8">

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @if (Session::has('status'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('status') }}</p>
            @endif
            <div class="card position-relative">
                <div class="card-body p-0">
                    <table class="table table-hover mb-0 tiny-td">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('Title') }}</th>
                                <th scope="col" width="120" class="text-center">{{ __('Is Default?') }}</th>
                                <th scope="col" width="120" class="text-center">{{ __('Direction') }}</th>
                                <th scope="col" width="120" class="text-center">{{ __('Translates') }}</th>
                                <th scope="col" width="120" class="text-center">{{ __('Active') }}</th>
                                <th scope="col" width="120" class="text-center">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($languages) == 0)
                                <tr>
                                    <td colspan="6" style="background:#fff !important" class="text-center">
                                        <div class="not-result mb-4">
                                            <img src="{{ url('/') }}/assets/admin/not-result.jpg" alt="">
                                            <h2>{{ __('Sorry, no result found!') }}</h2>
                                            <p>{{ __('Would you like to add one now?') }}</p>
                                            <a href="{{ route('admin.pages.create') }}" class="btn btn-primary"><i
                                                    class="fa fa-plus"></i>
                                                {{ __('Add New') }}</a>
                                        </div>
                                    </td>
                                </tr>
                            @else
                                @foreach ($languages as $lang)
                                    <tr>
                                        <td><span
                                                class="btn btn-border btn-secondary btn-sm">{{ $lang->slug }}</span>
                                            {{ $lang->title }}</td>
                                        <td class="text-center"><span
                                                class="badge badge-{{ $lang->default ? 'success' : 'danger' }}">{{ $lang->default ? __('Yes') : __('No') }}</span>
                                        </td>
                                        <td class="text-center"><b>{{ $lang->rtl ? 'RTL' : 'LTR' }}</b></td>
                                        <td class="text-center"><a href="{{ route('admin.settings.editTranslates', ['slug' => $lang->slug]) }}"
                                                class="btn btn-border btn-primary btn-sm"><i class="fa fa-globe"></i>
                                                {{ __('Edit Translates') }}</a></td>
                                        <td class="text-center"><span
                                                class="badge badge-{{ $lang->active ? 'success' : 'danger' }}">{{ $lang->active ? __('Active') : __('Inactive') }}</span>
                                        </td>
                                        <td class="text-center">
                                            <a href="javascript:;" data-id="{{ $lang->id }}"
                                                data-section="languages" class="btn btn-danger btn-sm delete-single"><i
                                                    class="fa fa-trash"></i></a>
                                            <a href="javascript:;" data-toggle="modal" data-target="#edit-language"
                                                data-data='{{ json_encode(['id' => $lang->id, 'slug' => $lang->slug, 'title' => $lang->title, 'default' => $lang->default, 'active' => $lang->active, 'rtl' => $lang->rtl]) }}'
                                                class="btn btn-warning btn-sm edit-lang"><i class="fa fa-edit"></i></a>
                                        </td>
                                    </tr>
                                @endforeach

                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="edit-language" tabindex="-1" aria-labelledby="edit-language-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit-language-label" data-new-title="{{ __('New Language') }}"
                    data-edit-title="{{ __('Edit Language') }}"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.settings.saveLang') }}" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id" class="form-control" id="id" value="">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="title">{{ __('Title') }}</label>
                        <input type="text" id="title" name="title" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="slug">{{ __('Short Title') }}</label>
                        <input type="text" name="slug" id="slug" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="rtl">{{ __('Direction') }}</label>
                        <select name="rtl" id="rtl" class="form-control">
                            <option value="0">LTR</option>
                            <option value="1">RTL</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="default">{{ __('Is Default?') }}</label>
                        <select name="default" id="default" class="form-control">
                            <option value="0">{{ __('No') }}</option>
                            <option value="1">{{ __('Yes') }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="active">{{ __('Active') }}</label>
                        <select name="active" id="active" class="form-control">
                            <option value="1">{{ __('Yes') }}</option>
                            <option value="0">{{ __('No') }}</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Save Changes') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('.edit-lang').click(function() {
        var elm = $(this);
        var data = elm.attr('data-data');
        var title = $('#edit-language-label');
        title.text(title.attr('data-edit-title'));
        data = JSON.parse(data);
        $.each(data, function(item, i) {
            $('#' + item).val(i);
        })
    })
    $('.add-new-lang').click(function(){
        var elm = $(this);
        var modal = $('#edit-language');
        modal.find('.form-control').val('');
        modal.find('select').each(function(i, item){
            $(item).find('option').first().prop('selected', true)
        })
        var title = $('#edit-language-label');
        title.text(title.attr('data-new-title'));
    })
</script>
