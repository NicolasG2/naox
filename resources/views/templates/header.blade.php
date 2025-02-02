<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <title>Naox</title>

    <link rel="stylesheet" href="{{ asset('css/home.css') }}">

</head>

<body>
    <nav class="navbar sticky-top navbar-expand-md">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#itens">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li>
                        <a href="{{ route('home') }}">
                            <i class="material-icons">next_week</i>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('clientes.index') }}">
                            <i class="material-icons">groups</i>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('fornecedores.index') }}">
                            <i class="material-icons">local_shipping</i>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('produtos.index') }}">
                            <i class="material-icons">fastfood</i>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('ingredientes.index') }}">
                            <i class="material-icons">local_grocery_store</i>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('estoque.index') }}">
                            <i class="material-icons">archive</i>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('users.index') }}">
                            <i class="material-icons">assignment_ind</i>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('settings.settings') }}">
                            <i class="material-icons">settings</i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    @yield('conteudo')
</body>
<div class="modal fade" tabindex="-1" id="removeModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">Operação de Remoção</h5>
                <button type="button" class="btn-close" data-bs-dismiss="removeModal" onclick="closeRemoveModal()"
                    aria-label="Close"></button>
            </div>
            <input type="hidden" id="id_remove">
            <div class="modal-body text-secondary">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-block align-content-center"
                    onclick="closeRemoveModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        class="bi bi-arrow-left-square-fill" viewBox="0 0 16 16">
                        <path
                            d="M16 14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12zm-4.5-6.5H5.707l2.147-2.146a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708-.708L5.707 8.5H11.5a.5.5 0 0 0 0-1z" />
                    </svg>
                    &nbsp; Não
                </button>
                <button type="button" class="btn btn-danger" onclick="remove()">
                    Sim &nbsp;
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" id="fotoModal">
    <div class="modal-dialog">
        <div class="modal-content">

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/jquery.mask.min.js') }}"></script>

<script type="text/javascript">
    function formatarTelefone(telefone) {
        var digits = telefone.replace(/\D/g, '');

        if (digits.length === 11) {
            return '(' + digits.substring(0, 2) + ') ' + digits.substring(2, 7) + '-' + digits.substring(7, 11);
        } else if (digits.length === 10) {
            return '(' + digits.substring(0, 2) + ') ' + digits.substring(2, 6) + '-' + digits.substring(6, 10);
        } else {
            return digits;
        }
    }

    $(document).ready(function() {
        $('#telefone').on('blur', function(event) {
            var telefone = $(this).val();
            var telefoneFormatado = formatarTelefone(telefone);
            $(this).val(telefoneFormatado);
        });
    });

    function formatarDocumento(documento) {
        var digits = documento.replace(/\D/g, '');

        if (digits.length === 11) {
            return digits.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
        } else if (digits.length === 14) { 
            return digits.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, "$1.$2.$3/$4-$5");
        } else {
            return digits; 
        }
    }

    $(document).ready(function() {
        $('#documento').on('blur', function(event) {
            var documento = $(this).val();
            var documentoFormatado = formatarDocumento(documento);
            $(this).val(documentoFormatado);
        });
    });

    $(document).ready(function() {
        $('.date').mask('00/00/0000');
        $('.time').mask('00:00:00');
        $('.date_time').mask('00/00/0000 00:00:00');
        $('.cep').mask('00000-000');
        $('.phone_us').mask('(000) 000-0000');
        $('.mixed').mask('AAA 000-S0S');
        $('.cpf').mask('000.000.000-00', {
            reverse: true
        });
        $('.cnpj').mask('00.000.000/0000-00', {
            reverse: true
        });
        $('.money').mask('000.000.000.000.000,00', {
            reverse: true
        });
        $('.money2').mask("#.##0,00", {
            reverse: true
        });
        $('.ip_address').mask('0ZZ.0ZZ.0ZZ.0ZZ', {
            translation: {
                'Z': {
                    pattern: /[0-9]/,
                    optional: true
                }
            }
        });
        $('.ip_address').mask('099.099.099.099');
        $('.percent').mask('##0,00%', {
            reverse: true
        });
        $('.clear-if-not-match').mask("00/00/0000", {
            clearIfNotMatch: true
        });
        $('.placeholder').mask("00/00/0000", {
            placeholder: "__/__/____"
        });
        $('.fallback').mask("00r00r0000", {
            translation: {
                'r': {
                    pattern: /[\/]/,
                    fallback: '/'
                },
                placeholder: "__/__/____"
            }
        });
        $('.selectonfocus').mask("00/00/0000", {
            selectOnFocus: true
        });
    });

    function showRemoveModal(id, nome) {
        $('#id_remove').val(id);
        $('#removeModal').modal().find('.modal-body').html("");
        $('#removeModal').modal().find('.modal-body').append("Deseja remover o registro <b class='text-danger'>'" +
            nome + "'</b> ?");
        $("#removeModal").modal('show')
    }

    function closeRemoveModal() {
        $("#removeModal").modal('hide')
    }

    function showFotoModal(path, foto) {

        let img
        path += "/" + foto
        img = "<img src='" + path + "'>"

        $('#fotoModal').modal().find('.modal-content').html("");
        $('#fotoModal').modal().find('.modal-content').append(img);
        $("#fotoModal").modal('show')
    }

    function remove() {

        let id = $('#id_remove').val();
        let form = "form_" + $('#id_remove').val();
        document.getElementById(form).submit();
        $("#removeModal").modal('hide')
    }

    function showNewYearModal(id, nome) {
        $("#newYearModal").modal('show')
    }

    function closeNewYearModal() {
        $("#newYearModal").modal('hide')
    }

    function newYear() {

        if ($('#ano_letivo').val() != "") {
            $('#novo_ano').val($('#ano_letivo').val());
            document.getElementById('form-recriar').submit();
        }

        $("#newYearModal").modal('hide')
    }
</script>
@yield('script')

</html>
