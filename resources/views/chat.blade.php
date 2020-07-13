@extends('master')

@section('content')

    <div class="container my-5 d-flex justify-content-center">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title mb-0">Robô ajudante</h2>
                <small id="botStatus">Online</small>
            </div>
            <div class="card-body">
                <div class="conversation">

                </div>
            </div>
            <div class="card-footer">
                <form  action="{{ url('/botman', [], true) }}" method="POST" id="conversation" autocomplete="off">
                    <div class="input-group mb-3">
                        <input type="text" id="userInput" name="userInput" class="form-control p-4 bg-dark border-dark text-light"
                            placeholder="Escreva alguma mensagem..." />
                        <div class="input-group-append">
                            <button class="btn btn-success" type="submit" id="btnSend">
                                Enviar
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection