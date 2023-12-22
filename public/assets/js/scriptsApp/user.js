$(() => {

    // Toast para validaciones
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
     
});

// Refresh tabla de usuarios
function Cargar()
{
    $("#table-user").load(window.location + " #table-user");
}

// Limpiar inputs
function cleanInput(btn){

    const bool = (btn == null) ? false : true;

    $('#username').val('').attr('disabled', bool);
    $('#email').val('').attr('disabled', bool);
    $('#password').val('').attr('disabled', bool);
    $('#name').val('').attr('disabled', bool);
    $('#lastname').val('').attr('disabled', bool);
    $('#address').val('').attr('disabled', bool);
    $('#phone').val('').attr('disabled', bool);
    $('#gender').val('').attr('disabled', bool);
    $("#exampleRadios2").prop("checked", true );

}

// Mostrar usuario según su Id
function showDataUser(btn){

    $.get("show/"+ btn, (response) => {

        let std = response.userFull;

        $('#username').val(std.username);
        $('#email').val(std.email);
        $('#name').val(std.profile.name);
        $('#lastname').val(std.profile.lastname);
        $('#address').val(std.profile.address);
        $('#phone').val(std.profile.phone);
        $('#gender').val(std.profile.gender);
        $("#exampleRadios1").prop("checked", std.admin == '1');
        $("#exampleRadios2").prop("checked", std.admin == '0');
       
    });

}

// Ver, Registrar y actualizar usuario en ventana modal
function showUsr(btn)
{
    $('#myModal').modal();
    $('#exampleModalLabel').html("<b>Detalles usuario</b>");

    // LIMPIAR CAMPOS
    cleanInput(btn);

    showDataUser(btn);
    // FIN LIMPIAR CAMPOS

    let u = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>';

    $(".modal-footer").html(u);

}

function regUsr()
{
    $('#myModal').modal();
    $('#exampleModalLabel').html('Nuevo usuario');

     // LIMPIAR CAMPOS
    cleanInput();
    
    // FIN LIMPIAR CAMPOS

    let r = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>'+
            '<button id="registro" class="btn btn-primary" onclick="registerUsr()" >Agregar</button>';
            
    $(".modal-footer").html(r);

}

function upUsr(btn)
{
    $('#myModal').modal();
    $('#exampleModalLabel').html('Actualizar usuario');

    // LIMPIAR CAMPOS
    cleanInput();

    showDataUser(btn);
    // FIN LIMPIAR CAMPOS

    let u = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>'+
            '<button id="editar" class="btn btn-dark" onclick="updateUsr('+btn+')">Editar</button>';

    $(".modal-footer").html(u);

}

// CRUD Usuarios
// Registrar nuevo usuario
function registerUsr()
{
    let route = '/auth/create';

    let ajax_data = {

        username: $('#username').val(),
        email: $('#email').val(),
        password: $('#password').val(),
        name: $('#name').val(),
        lastname: $('#lastname').val(),
        address: $('#address').val(),
        phone: $('#phone').val(),
        gender: $('#gender').val(),

    };

    $.ajax({
        url: route,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        type: 'POST',
        dataType: 'json',
        data: ajax_data,
    }).then(response => {

        Cargar();
        $('#myModal').modal('toggle');
        toastr.success(response.message);
                 
    })
    .catch(e => {

        const arr = e.responseJSON;
        const toast = arr.errors;
    
        // Validación de campos registrar usuario
        if (e.status == 422) {

            if (toast.username != null) toastr.error(toast.username[0]);
            if (toast.email != null) toastr.error(toast.email[0]);
            if (toast.password != null) toastr.error(toast.password[0]);
            if (toast.name != null) toastr.error(toast.name[0]);
            if (toast.lastname != null) toastr.error(toast.lastname[0]);
            if (toast.address != null) toastr.error(toast.address[0]);
            if (toast.phone != null) toastr.error(toast.phone[0]);
            if (toast.gender != null) toastr.error(toast.gender[0]);

        }

         // Validación si no se cuenta con permisos para una acción
         else if(e.status == 403){

            $('#myModal').modal('toggle');
            toastr.warning(arr.error);

        }

    });
    

}

// Actulizar datos del usuario
function updateUsr(btn)
{  
    $('#myModal').modal();
   
    let route = "/auth/update/"+btn;

    let ajax_data = {

        username: $('#username').val(),
        email: $('#email').val(),
        password: $('#password').val(),
        admin: $(".field:checked").val(),
        name: $('#name').val(),
        lastname: $('#lastname').val(),
        address: $('#address').val(),
        phone: $('#phone').val(),
        gender: $('#gender').val(),

    };

    $.ajax({
        url: route,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), 'X-HTTP-Method-Override': 'PUT' },
        type: 'POST',
        dataType: 'json',
        data: ajax_data,
    }).then(response => {
    
        Cargar();
        $('#myModal').modal('toggle');
        toastr.success(response.message);

    })
    .catch(e => {

        const arr = e.responseJSON;
        const toast = arr.errors;
    
        // Validación de campos actualizar usuario
        if (e.status == 422) {

            if (toast.username != null) toastr.error(toast.username[0]);
            if (toast.email != null) toastr.error(toast.email[0]);
            if (toast.password != null) toastr.error(toast.password[0]);
            if (toast.name != null) toastr.error(toast.name[0]);
            if (toast.lastname != null) toastr.error(toast.lastname[0]);
            if (toast.address != null) toastr.error(toast.address[0]);
            if (toast.phone != null) toastr.error(toast.phone[0]);
            if (toast.gender != null) toastr.error(toast.gender[0]);

        }

        // Validación si no se cuenta con permisos para una acción
        else if(e.status == 403){

            $('#myModal').modal('toggle');
            toastr.warning(arr.error);

        }

    });

}

// Eliminar usuario solo usuario administrador
function deleteUsr(btn){

    let route = "/auth/delete/"+btn;
    
    Swal.fire({
        title: "¿Desea Eliminar este usuario de la lista?",
        showCancelButton: true,
        confirmButtonText: "Eliminar",
        cancelButtonText: "Cancelar",
        }).then((result) => {

        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            
            $.ajax({
                url: route,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                method: 'DELETE',
                dataType: 'json',
            }).then(response => {
    
                Cargar();
                $('#task-table').DataTable().ajax.reload();
                // toastr.success(response.success);
                Swal.fire(response.success, "", "success");
               
            })
            .catch(e => {
                
                // Validación de campos si no tiene el usuario permiso para eliminar
                const arr = e.responseJSON;
              
                 if(e.status == 403){
    
                    // toastr.warning(arr.error);
                    Swal.fire(arr.error, "", "info");
                  
                 }
            });

        }
    });

    
}
  