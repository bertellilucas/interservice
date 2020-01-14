function FormFieldsToJsonAndSendEmail() {
    var formulario = document.getElementById('formRequestViaAjax')
    var jsonData = {};
    $(formulario).serializeArray().forEach(elementos => {
        jsonData[elementos.name] = (elementos.value == '') ? null : elementos.value
    });

    if(!validateFieldsFromEmail(jsonData))
        return null
    else {
        addCustomAttributeToJson(jsonData, 'type', 'POST')
        addCustomAttributeToJson(jsonData, 'url', '../Controller/emailController.php')
        addCustomAttributeToJson(jsonData, 'idBtnRequest', 'btnValidarPreenchimento')
        return enviarEmailViaAjax(jsonData)
    }
}

function validateFieldsFromEmail(jsonData){
    if (jsonData.txtNome == null && jsonData.txtEmail == null && jsonData.txaMensagem == null && jsonData.sltAssunto == null)
        return false
    else
        return true
}

function addCustomAttributeToJson(jsonData, nomeCampo, valor) {
    jsonData[nomeCampo] = valor
}

function enviarEmailViaAjax(jsonData) {
    var responseEmail = null;
    $.ajax({
        type: jsonData.type,
        url: jsonData.url,//url a ser chamada
        data: jsonData,

        //antes do envio da requisição
        beforeSend: function () { addLoadingGif(jsonData.idBtnRequest) },
        
        //requisição sem erro
        success: function (response) { //response = retorno da função ajax
            responseEmail = response; },
        
        //erro na requisição
        error: function () { removeLoadingGif(jsonData.idBtnRequest); responseEmail = false },
        
        //Finalização da requisição
        complete: function () { removeLoadingGif(jsonData.idBtnRequest); validarEnvioEmailEsetarAlert(responseEmail) }//requisição completa
    });
}

function validarEnvioEmailEsetarAlert(sucessoAoEnviar){
    if(sucessoAoEnviar == false)
        document.getElementById('alert').innerHTML = getAlertErro();
    else if (sucessoAoEnviar == true)
        document.getElementById('alert').innerHTML = getAlertSucesso();
}

function getAlertErro(){
    return "<div class='alert alert-danger mt-5 text-center' role='alert'>"                                                 +
        "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>"                                      +
        "<span aria-hidden='true'>&times;</span>"                                                                           +
        "</button>"                                                                                                         +
        
        "<h4 class='alert-heading'>Desculpe, parece que algo deu errado! <i class='fa fa-exclamation-triangle'></i></h4>"   +
        "<hr>"                                                                                                              +
        "<p class='mb-0'>Não foi possível enviar o seu e-mail para nossa equipe.</p>"                                       +
        "<p class='mb-0'>Por favor, tente novamente mais tarde.</p>"                                                        +
    "</div>"
}

function getAlertSucesso(){
    return "<div class='alert alert-success mt-5 text-center' role='alert'>"                                    +
            "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>"                      +
              "<span aria-hidden='true'>&times;</span>"                                                         +
            "</button>"                                                                                         +
            
            "<h4 class='alert-heading'>E-mail enviado com sucesso! <i class='fa fa-paper-plane-o'></i> </h4>"   +
            "<hr>"                                                                                              +
            "<p class='mb-0'>Em breve um dos nossos representantes entrará em contato com você.</p>"            +
          "</div>"
}

function removeLoadingGif(elementId){
    $('#' + elementId).removeClass('bg-gif gif-purple-loader')
    $('#' + elementId).removeClass('disabled')
}

function addLoadingGif(elementId){
    $('#' + elementId).addClass('bg-gif gif-purple-loader')
    $('#' + elementId).addClass('disabled')
}