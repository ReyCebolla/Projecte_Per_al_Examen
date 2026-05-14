$(document).ready(function () {

    //Si l'usuari vol tancar la sessió
    $("#exit").click(function () {
        var exit = confirm("Estas segur que vols abandonar la sessio?");
        if (exit == true) {
            window.location = 'index.php';
        }
    });

    $("#enter").click(function () {

        user = $("#name").val();
        pass = $("#pass").val();

        credencials = {usuari: user, password: pass};

        if (user == "" || pass == "") {
            $('.error').show();
            $('.error').html('Siusplau introdueix usuari i contrassenya');
        } else {

            $.ajax({
                type: 'GET',
                url: './controllers/controller.php',
                dataType: 'json',
                contentType: "application/json; charset=utf-8",
                data: {
                    credencials: JSON.stringify(credencials)
                },
                success: function (suc) {

                    if (suc.resposta == 1) {
                        $('.error').hide();
                        $("#loginform").hide();
                        $('#wrapper').show();
                        $('#nom').html(user);
                    } else {
                        $('.error').show();
                        $('.error').html('Usuari o contrassenya incorrectes');
                    }
                },
                error: function () {
                    alert('An error occurred!');
                }
            });
        }
    });

    //llista clients

    $("#mdadesc").click(function () {

        clients = {client: "llistaclient"};

        $.ajax({
            type: 'GET',
            url: './controllers/controller.php',
            dataType: 'json',
            contentType: "application/json; charset=utf-8",
            data: {
                mclients: JSON.stringify(clients)
            },
            success: function (suc) {

                filesTaula = "";

                $.each(suc, function (i, client) {
                    if (client.nom != 'Administrador') {
                        filesTaula = filesTaula + '<tr><td><input type="text" value="' + client.id + '" readonly style="background:#eee;"/></td><td><input type="text" value="' + client.nom + '"/></td><td><input type="text" value="' + client.adreca + '"/></td><td><input type="text" value="' + client.ciutat + '"/></td><td><input type="checkbox"/></td></tr>';
                    } else {
                        filesTaula = filesTaula + '<tr><td><input type="text" value="' + client.id + '" disabled/></td><td><input type="text" value="' + client.nom + '" disabled/></td><td><input type="text" value="' + client.adreca + '" disabled/></td><td><input type="text" value="' + client.ciutat + '" disabled/></td><td><input type="checkbox" disabled/></td></tr>';
                    }
                });
                alert(filesTaula);
                $("#clienttb").html(filesTaula);

            },
            error: function () {
                alert('An error occurred!');
            }
        });

    });

    //esborrar clients
    $("#edadesc").click(function () {

        // 1. Añadimos un array vacío 'ids' al objeto que creó el profesor
        clients = {client: "esborraclient", ids: []};

        for (i = 0; i < $("#clienttb input[type=checkbox]").length; i++) {
            if ($("#clienttb input[type=checkbox]").eq(i).is(':checked')) {
                // En vez de alert(i), buscamos el ID de esa fila concreta y lo guardamos
                var id_fila = $("#clienttb tr").eq(i).find("td:eq(0) input").val();
                clients.ids.push(id_fila);
            }
        }

        if (clients.ids.length > 0) {
            $.ajax({
                type: 'POST',
                url: './controllers/controller.php',
                dataType: 'json',
                data: {
                    accio_client: JSON.stringify(clients)
                },
                success: function (suc) {
                    $("#mdadesc").click();
                },
                error: function () {
                    alert('An error occurred!');
                }
            });
        }
    });

    //actualitzar clients
    $("#adadesc").click(function () {

        var clients = {client: "actualitzaclient", dades: []};

        for (i = 0; i < $("#clienttb input[type=checkbox]").length; i++) {
            if ($("#clienttb input[type=checkbox]").eq(i).is(':checked')) {
                // Agafem les dades de la fila 'i'
                var c_id = $("#clienttb tr").eq(i).find("td:eq(0) input").val();
                var c_nom = $("#clienttb tr").eq(i).find("td:eq(1) input").val();
                var c_adreca = $("#clienttb tr").eq(i).find("td:eq(2) input").val();
                var c_ciutat = $("#clienttb tr").eq(i).find("td:eq(3) input").val();

                clients.dades.push({id: c_id, nom: c_nom, adreca: c_adreca, ciutat: c_ciutat});
            }
        }

        if (clients.dades.length > 0) {
            $.ajax({
                type: 'POST',
                url: './controllers/controller.php',
                dataType: 'json',
                data: {accio_client: JSON.stringify(clients)},
                success: function (suc) {
                    $("#mdadesc").click();
                },
                error: function () {
                    alert('An error occurred!');
                }
            });
        }
    });

    //mostrar llibres
    $("#mdadesl").click(function () {
        var llibres = {llibre: "llistallibre"};
        $.ajax({
            type: 'GET',
            url: './controllers/controller.php',
            dataType: 'json',
            contentType: "application/json; charset=utf-8",
            data: {mllibres: JSON.stringify(llibres)},
            success: function (suc) {
                var filesTaula = "";
                $.each(suc, function (i, llibre) {
                    filesTaula += '<tr><td><input type="text" value="' + llibre.isbn + '" readonly style="background:#eee;"/></td><td><input type="text" value="' + llibre.autor + '"/></td><td><input type="text" value="' + llibre.titol + '"/></td><td><input type="text" value="' + llibre.preu + '"/></td><td><input type="checkbox"/></td></tr>';
                });
                $("#llibretb").html(filesTaula);
            },
            error: function () {
                alert('Error carregant llibres');
            }
        });
    });

    //esborrar llibres
    $("#edadesl").click(function () {

        var llibres = {llibre: "esborrallibre", isbns: []};

        for (i = 0; i < $("#llibretb input[type=checkbox]").length; i++) {
            if ($("#llibretb input[type=checkbox]").eq(i).is(':checked')) {
                var l_isbn = $("#llibretb tr").eq(i).find("td:eq(0) input").val();
                llibres.isbns.push(l_isbn);
            }
        }

        if (llibres.isbns.length > 0) {
            $.ajax({
                type: 'POST',
                url: './controllers/controller.php',
                dataType: 'json',
                data: {accio_llibre: JSON.stringify(llibres)},
                success: function (suc) {
                    $("#mdadesl").click();
                },
                error: function () {
                    alert('An error occurred!');
                }
            });
        }
    });

    //actualitzar llibres
    $("#adadesl").click(function () {

        var llibres = {llibre: "actualitzallibre", dades: []};

        for (i = 0; i < $("#llibretb input[type=checkbox]").length; i++) {
            if ($("#llibretb input[type=checkbox]").eq(i).is(':checked')) {
                var l_isbn = $("#llibretb tr").eq(i).find("td:eq(0) input").val();
                var l_autor = $("#llibretb tr").eq(i).find("td:eq(1) input").val();
                var l_titol = $("#llibretb tr").eq(i).find("td:eq(2) input").val();
                var l_preu = $("#llibretb tr").eq(i).find("td:eq(3) input").val();

                llibres.dades.push({isbn: l_isbn, autor: l_autor, titol: l_titol, preu: l_preu});
            }
        }

        if (llibres.dades.length > 0) {
            $.ajax({
                type: 'POST',
                url: './controllers/controller.php',
                dataType: 'json',
                data: {accio_llibre: JSON.stringify(llibres)},
                success: function (suc) {
                    $("#mdadesl").click();
                },
                error: function () {
                    alert('An error occurred!');
                }
            });
        }
    });


});

