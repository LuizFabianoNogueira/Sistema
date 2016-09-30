<?php
    function subMenu($array)
    {
        $retorno = '';
        $retorno .= '<ol class="dd-list">';
        foreach ($array as $item)
        {
            $retorno .= '<li class="dd-item" data-id="'.$item["id"].'">';
                $retorno .= '<div class="dd-handle"> '.$item["id"].' - '.$item["name"].' | '.$item["route"].' </div>';
                if(isset($item['childs']) && count($item['childs'])>0)
                    {
                        $retorno .= subMenu($item['childs']);
                    }
            $retorno .= '</li>';
        }
        $retorno .= '</ol>';
        return $retorno;
    }
?>

@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Menu Grupo - {{ $grupo  }}   </h5>
                    <div class="ibox-tools">
                        <a class="btn btn-primary btn-xs" href=" {{ route('menus.newGet') }}">Novo</a>
                    </div>
                </div>
                <div class="ibox-content">

                    <p  class="m-b-lg">
                        <strong>Atenção</strong> Ao mover os menus o mesmo sera salvo!
                    </p>

                    <div class="dd" id="nestable">
                        <ol class="dd-list">
                            @foreach($menus as $menu)
                            <li class="dd-item" data-id=" {{ $menu['id'] }} ">
                                <div class="dd-handle">1 - {{ $menu['name'] }} | {{ $menu['route'] }}</div>
                                @if(isset($menu['childs']) && count($menu['childs'])>0)
                                <?php echo subMenu($menu['childs']); ?>
                                @endif
                            </li>
                            @endforeach
                        </ol>
                    </div>
                    <div class="m-t-md">
                        <h5>Serialised Output</h5>
                    </div>
                    <textarea id="nestable-output" class="form-control"></textarea>

                </div>
            </div>
        </div>

    </div>

    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@push('scripts')
<!-- Nestable List -->
<script src=" {{ asset('js/plugins/nestable/jquery.nestable.js') }} "></script>
<script src=" {{ asset('js/plugins/toastr/toastr.min.js') }} "></script>

<script type="text/javascript">
    <!--
    $(document).ready(function() {
        var updateOutput = function (e) {
            var list = e.length ? e : $(e.target),
                    output = list.data('output');
            if (window.JSON) {
                var dados = window.JSON.stringify(list.nestable('serialize'));

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "json",
                    type: "POST",
                    url: '{{ route('menus.updatePost') }}',
                    data: { dados: list.nestable('serialize') } ,
                    success: function (data) {
                            toastr.success(data.result);
                        //output.val(data.result);
                    },
                });

            } else {
                output.val('JSON browser support required for this demo.');
            }
        };

        $('#nestable').nestable({
            group: 1
        }).on('change', updateOutput);

        updateOutput($('#nestable').data('output', $('#nestable-output')));

        $('#nestable-menu').on('click', function (e) {
            var target = $(e.target),
                    action = target.data('action');
            if (action === 'expand-all') {
                $('.dd').nestable('expandAll');
            }
            if (action === 'collapse-all') {
                $('.dd').nestable('collapseAll');
            }
        });
    });
    -->
</script>
@endpush

