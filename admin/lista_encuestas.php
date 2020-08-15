<?php
    global $wpdb;



    $tabla = "{$wpdb->prefix}encuestas";
    $tabla2 = "{$wpdb->prefix}encuenstas_detalle";

      if(isset($_POST['btnguardar'])){
        
          $nombre = $_POST['txtnombre'];
          $query = "SELECT EncuestaId FROM $tabla ORDER BY EncuestaId DESC limit 1";
          $resultado = $wpdb->get_results($query,ARRAY_A);
          $proximoId = $resultado[0]['EncuestaId'] + 1;
          $shortcode = "[ENC id='$proximoId']";

          $datos = [
              'EncuestaId' => null,
              'Nombre' => $nombre,
              'ShortCode' => $shortcode
          ];
          $respuesta =  $wpdb->insert($tabla,$datos);

          if($respuesta){
             $listapreguntas = $_POST['name'];
             $i = 0;
             foreach ($listapreguntas as $key => $value) {
                  $tipo = $_POST['type'][$i];
                  $datos2 = [
                      'DetalleId' => null,
                      'EncuestaId' => $proximoId,
                      'Pregunta' => $value,
                      'Tipo' => $tipo
                  ];

                  $wpdb->insert($tabla2,$datos2);

                  $i++;
             }
          }
      }




    $query = "SELECT * FROM $tabla";
    $lista_encuestas = $wpdb->get_results($query,ARRAY_A);
    if(empty($lista_encuestas)){
        $lista_encuestas = array();
    }
    
 ?>
 <div class="wrap">
        <?php
             echo "<h1 class='wp-heading-inline'>" . get_admin_page_title() . "</h1>";
        ?>
         <a id="btnnuevo" class="page-title-action">Añadir nueva</a>

         <br><br><br>

         <table class="wp-list-table widefat fixed striped pages">
                <thead>
                    <th >Nombre de la encuestas</th>
                    <th >ShortCode</th>
                    <th >Acciones</th>
                </thead>
                <tbody id="the-list">
                    <?php 
                        foreach ($lista_encuestas as $key => $value) {
                          $id = $value['EncuestaId'];
                         $nombre = $value['Nombre'];
                         $shortcode = $value['ShortCode'];
                           echo "
                                <tr>
                                    <td>$nombre</td>
                                    <td>$shortcode </td>
                                    <td>
                                      <a data-ver='$id' class='page-title-action'>Ver estadisticas</a>
                                      <a data-id='$id' class='page-title-action'>Borrar</a>
                                    </td>
                                </tr>
                            ";
                        }

                    ?>
                </tbody>
        </table>


 </div>





<!-- Modal -->
<div class="modal fade" id="modalnuevo" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLongTitle">Nueva encuesta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
          <form method="post">

              <div class="modal-body">
                  
                        <div class="form-group">
                          <label for="txtnombre" class="col-sm-4 col-form-label">Nombre de la encuesta</label>
                          <div class="col-sm-8">
                              <input type="text" id="txtnombre" name="txtnombre" style="width:100%">
                          </div>
                        </div>
                        <br>
                        <hr>
                        <h4> Preguntas</h4>
                        <hr>
                        <br>
                        <table id="camposdinamicos">
                          <tr>  
                              <td>
                                 <label for="txtnombre" class="col-form-label" style="margin-right:5px">Pregunta 1</label>
                              </td>
                              <td>
                                  <input type="text" name="name[]" id="name" class="form-control name_list">
                              </td>
                              <td>
                                <select name="type[]" id="type" class="form-control type_list"  style="margin-left:5px">
                                      <option value="1" select>SI - NO</option>
                                      <option value="2"> Rango 0 - 5</option>
                                      <option value="3"> Respuesta breve</option>
                                </select>
                              
                              </td>
                              <td>
                                  <button name="add" id="add" class="btn btn-success" style="margin-left:15px">Agregar mas</button>
                              </td>
                          </tr>
                        </table>


              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" name="btnguardar" id="btnguardar">Guardar</button>
              </div>
         </form>

    </div>
  </div>
</div>




<!-- Ver estadisticas -->
<div class="modal fade" id="modalestadisticas" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLongTitle">Estadisticas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>




    </div>
  </div>
</div>


