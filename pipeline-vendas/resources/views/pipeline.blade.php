@extends('index')

@section('css-props')
<link rel="stylesheet" href="{{URL::asset('css/pipeline.css')}}" />
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css"> -->
@endsection

@section('sidebar')
@parent
@endsection

@section('content')
@if(isset($_GET["op"]))
@if($_GET["op"] == "sucess")
<div class="alert alert-primary alert-dismissible fade show" role="alert">
  <strong>Registro inserido!</strong>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@elseif($_GET["op"] == "error")
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Erro ao tentar inserir registro!</strong>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@elseif($_GET["op"] == "updated")
<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Alteração Realizada!</strong>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif

@endif
<div class="table_title text-center">
  <span>Planilha de Dados</span>
  <hr>
</div>
<table id="pipeline-table" class="table-responsive table-striped planilha-dados">
  <thead>
    <tr class="head-table">
      <th scope="col"></th>
      <th scope="col"></th>
      <th scope="col">Cliente</th>
      <th scope="col">Projeto</th>
      <th scope="col">Valor/m³</th>
      <th scope="col">Volume (m³/mês)</th>
      <th scope="col">Data Abertura</th>
      <th scope="col">Data Início <br>Operação</th>
      <th scope="col">Prazo <br/> Contrato</th>
      <th scope="col">Probabilidade</th>
      <th scope="col">Situação</th>
      <th scope="col">Data <br/>Encerramento</th>
      <th scope="col">Tempo <br/> 2020 (meses)</th>
      <th scope="col">Receita <br/> Estimada</th>
      <th scope="col">Receita <br/> Esperada</th>
      <th scope="col">Impacto <br/> 2020</th>
      <th scope="col">Duração</th>
      <th scope="col">Mudança <br/> Status</th>
    </tr>
  </thead>
  <tbody>

    @if(isset($op) and $op == "create")
    <form id="pipeline_form" action="{{action('PipelineController@create')}}" method="post">
      @csrf
      <tr>
        <td>
          @if(isset($op) and $op == "create")

            <button id="btn_cancel" class="btn btn-default btn-remover" type="button" title="Limpar Dados"><a href="." style="text-decoration: none"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-backspace" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M6.603 2h7.08a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1h-7.08a1 1 0 0 1-.76-.35L1 8l4.844-5.65A1 1 0 0 1 6.603 2zm7.08-1a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-7.08a2 2 0 0 1-1.519-.698L.241 8.65a1 1 0 0 1 0-1.302L5.084 1.7A2 2 0 0 1 6.603 1h7.08zM5.829 5.146a.5.5 0 0 0 0 .708L7.976 8l-2.147 2.146a.5.5 0 0 0 .707.708l2.147-2.147 2.146 2.147a.5.5 0 0 0 .707-.708L9.39 8l2.146-2.146a.5.5 0 0 0-.707-.708L8.683 7.293 6.536 5.146a.5.5 0 0 0-.707 0z"/>
            </svg></a></button>
        </td>
        <td><button id="btn_save" class="btn btn-default"
          type="submit" title="Gravar"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15.354 2.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L8 9.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
            <path fill-rule="evenodd" d="M8 2.5A5.5 5.5 0 1 0 13.5 8a.5.5 0 0 1 1 0 6.5 6.5 0 1 1-3.25-5.63.5.5 0 1 1-.5.865A5.472 5.472 0 0 0 8 2.5z"/>
          </svg></button></td>
        <td><input id="inpt_cliente" class="form-add input-md" type="text" name="cliente"></td>
        <td><input class="form-add input-lg" type="text" name="projeto"></td>
        <td><input id="inpt_val" class="form-add input-sm" type="text" name="valor_m3"></td>
        <td><input id="inpt_vol" class="form-add input-sm" type="text" name="volume_m3"></td>
        <td><input class="form-add input-lg" type="date" name="dt_abertura"></td>
        <td><input class="form-add input-lg" type="date" name="dt_inicio_op"></td>
        <td><input id="inpt_prz" class="form-add input-sm" type="text" name="prazo_contrato"></td>
        <td>
          <select id="inpt_prob" class="form-add input-md" name="probabilidade">
            <option value="10">10%</option>
            <option value="30">30%</option>
            <option value="50">50%</option>
            <option value="80">80%</option>
            <option value="100">100%</option>
          </select>
        </td>
        <td>
          <select class="form-add input-sm" name="id_tab_situacao">
            @foreach($situacoes_lst as $result)
            <option value="<?=$result->ID_TAB_SITUACAO?>"><?=$result->SITUACAO?></option>
            @endforeach
          </select>
        </td>
        <td><input class="form-add input-lg" type="date" name="dt_encerramento"></td>
        <td><input id="inpt_tempo" class="form-add input-sm" type="text" name="tempo"></td>
        <td><input id="inpt_rec_est" class="form-add input-lg" type="text" name="receita_est" disabled></td>
        <td><input id="inpt_rec_esp" class="form-add input-lg" type="text" name="receita_esp" disabled></td>
        <td><input id="inpt_impacto" class="form-add input-lg" type="text" name="impacto" disabled></td>
        <td><input id="inpt_dur" class="form-add input-sm" type="text" name="duracao" disabled></td>
        <td><input class="form-add input-sm" type="text" name="mudanca_sts" disabled></td>
      </tr>
    </form>
      
    @endif

    @elseif(isset($op) and $op == "update")
      <tr>
        <td><button id="btn_cancel" class="btn btn-default bt-action" type="button"><a href="."
              class="text-decoration-none">Cancelar</a></button>
        </td>
        <td>
        <button id="btn_update" class="btn btn-default bt-action"
            type="button">Salvar</button>
        </td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      @else
      <tr>
        <td colspan="18"> <button id="btn_add" class="btn btn-default" type="button"><span> Adicionar</span> </button> </td>
        
      </tr>
    @endif

    @php
    $lin = 1;
    @endphp
    @if(isset($pipeline))
    @foreach($pipeline as $result)
    <tr >

      @csrf
      <td title="Excluir">
        <button id="btn-remover-<?=$lin?>" class="btn btn-default"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/>
        </svg></button>
      </td>
      <td title="Editar">
        <button id="btn-editar-<?=$lin?>" class="btn btn-default"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
          <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
          <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
        </svg></button>
      </td>
      <td>
        <input id="id_<?=$lin?>" value="<?=$result->ID_PIPELINE?>" type="hidden">
        <input id='inpt_lin<?=$lin?>_col1' class="input_lst input-sm" type="text" value="<?=$result->CLIENTE?>">
      </td>
      <td><input id='inpt_lin<?=$lin?>_col2' class="input_lst input-lg" type="text" value="<?=$result->PROJETO?>">
      </td>
      <td><input id='inpt_lin<?=$lin?>_col3' class="val input_lst input-sm" type="text" value="<?=$result->VALOR?> ">
      </td>
      <td><input id='inpt_lin<?=$lin?>_col4' class="vol input_lst input-sm" type="text" value="<?=$result->VOLUME?>">
      </td>
      <td><input id='inpt_lin<?=$lin?>_col5' class="dt_ab input_lst input-lg" type="text"
          value="<?=$result->DT_ABERTURA?>" maxlength="10"></td>
      <td><input id='inpt_lin<?=$lin?>_col6' class="dt_ini input_lst input-lg" type="text"
          value="<?=$result->DT_INICIO?>" maxlength="10"></td>
      <td><input id='inpt_lin<?=$lin?>_col7' class="prz input_lst input-sm" type="text" value="<?=$result->PRAZO?>">
      </td>
      <td><input id='inpt_lin<?=$lin?>_col8' class="prob input_lst input-md" type="text"
          value="<?=$result->PROBAB?>"></td>
      <td>
        <input id='situ_lin<?=$lin?>' type="hidden" value="<?=$result->ID_TAB_SITUACAO[0]->ID_TAB_SITUACAO?>">
        <input id='inpt_lin<?=$lin?>_col9' class="sit input_lst input-sm" type="text"
          value="<?=$result->ID_TAB_SITUACAO[0]->SITUACAO?>">
      </td>
      <td><input id='inpt_lin<?=$lin?>_col10' class="dt_enc input_lst input-lg" type="text"
          value="<?=$result->DT_ENCERR?>" maxlength="10"></td>
      <td><input id='inpt_lin<?=$lin?>_col11' class="tmpo input_lst input-sm" type="text"
          value="<?=$result->TEMPO?>"></td>
      <td><input id='inpt_lin<?=$lin?>_col12' class="rec_est input_lst input-md" type="text"
          value="<?=$result->REC_ESTIMADA?>" disabled></td>
      <td><input id='inpt_lin<?=$lin?>_col13' class="rec_esp input_lst input-md" type="text"
          value="<?=$result->REC_ESPERADA?>" disabled></td>
      <td><input id='inpt_lin<?=$lin?>_col14' class="impcto input_lst input-md" type="text"
          value="<?=$result->IMPACTO?>" disabled></td>
      <td><input id='inpt_lin<?=$lin?>_col15' class="dur input_lst input-sm  " type="text"
          value="<?=$result->DURACAO?>" disabled></td>
      <td><input id='inpt_lin<?=$lin?>_col16' class="mud input_lst input-sm" type="text"
          value="<?=$result->MUDANCA_STS?>" disabled></td>        
    </tr>
    @php
    $lin++;
    @endphp
    @endforeach
    @endif
    <input type="hidden" value="<?=$lin - 1?>" id="qtdeLinhas">   
  </tbody>
</table>
<div>
 
  
</div>
@endsection

@section('script')
<script type="text/javascript" src="{{ URL::asset('js/pipeline.js') }}"></script>

<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<!-- <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script> -->


@endsection