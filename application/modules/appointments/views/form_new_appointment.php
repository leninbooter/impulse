<form id="newSuscriptionForm" class="form-horizontal" method="post" action="<?=base_url('index.php/Appointments/add')?>">    
    <input type="hidden" name="suscription[id]" value="">
    <div class="form-group">
        <!--<label class="col-sm-2 control-label">Servicio</label>-->
        <div class="col-sm-7">
            <div id="datepicker"></div>
            <input type="hidden" name="appointment[fecha]" class="form-control">
            <!--<input type="text" name="suscription[servicio]" class="form-control">-->
        </div>
        <!--<label class="col-sm-2 control-label">Fecha</label>-->
        <div class="col-sm-5">
            <select class="form-control form-cascade-control input-small" name="appointment[hora]">
            <option <?=isset($cita) && substr($cita[0]["fechahora"], 11,5) == "07:00" ? 'selected':''?> >07:00</option>
            <option <?=isset($cita) && substr($cita[0]["fechahora"], 11,5) == "07:30" ? 'selected':''?>>07:30</option>
            <option <?=isset($cita) && substr($cita[0]["fechahora"], 11,5) == "08:00" ? 'selected':''?>>08:00</option>
            <option <?=isset($cita) && substr($cita[0]["fechahora"], 11,5) == "08:30" ? 'selected':''?>>08:30</option>
            <option <?=isset($cita) && substr($cita[0]["fechahora"], 11,5) == "09:00" ? 'selected':''?>>09:00</option>
            <option <?=isset($cita) && substr($cita[0]["fechahora"], 11,5) == "09:30" ? 'selected':''?>>09:30</option>
            <option <?=isset($cita) && substr($cita[0]["fechahora"], 11,5) == "10:00" ? 'selected':''?>>10:00</option>
            <option <?=isset($cita) && substr($cita[0]["fechahora"], 11,5) == "10:30" ? 'selected':''?>>10:30</option>
            <option <?=isset($cita) && substr($cita[0]["fechahora"], 11,5) == "11:00" ? 'selected':''?>>11:00</option>
            <option <?=isset($cita) && substr($cita[0]["fechahora"], 11,5) == "11:30" ? 'selected':''?>>11:30</option>
            <option <?=isset($cita) && substr($cita[0]["fechahora"], 11,5) == "12:00" ? 'selected':''?>>12:00</option>
            <option <?=isset($cita) && substr($cita[0]["fechahora"], 11,5) == "12:30" ? 'selected':''?>>12:30</option>
            <option <?=isset($cita) && substr($cita[0]["fechahora"], 11,5) == "13:00" ? 'selected':''?>>13:00</option>
            <option <?=isset($cita) && substr($cita[0]["fechahora"], 11,5) == "13:30" ? 'selected':''?>>13:30</option>
            <option <?=isset($cita) && substr($cita[0]["fechahora"], 11,5) == "14:00" ? 'selected':''?>>14:00</option>
            <option <?=isset($cita) && substr($cita[0]["fechahora"], 11,5) == "14:30" ? 'selected':''?>>14:30</option>
            <option <?=isset($cita) && substr($cita[0]["fechahora"], 11,5) == "15:00" ? 'selected':''?>>15:00</option>
            <option <?=isset($cita) && substr($cita[0]["fechahora"], 11,5) == "15:30" ? 'selected':''?>>15:30</option>
            <option <?=isset($cita) && substr($cita[0]["fechahora"], 11,5) == "16:00" ? 'selected':''?>>16:00</option>
            <option <?=isset($cita) && substr($cita[0]["fechahora"], 11,5) == "16:30" ? 'selected':''?>>16:30</option>
            <option <?=isset($cita) && substr($cita[0]["fechahora"], 11,5) == "17:00" ? 'selected':''?>>17:00</option>
            <option <?=isset($cita) && substr($cita[0]["fechahora"], 11,5) == "17:30" ? 'selected':''?>>17:30</option>
            <option <?=isset($cita) && substr($cita[0]["fechahora"], 11,5) == "18:00" ? 'selected':''?>>18:00</option>
            <option <?=isset($cita) && substr($cita[0]["fechahora"], 11,5) == "18:30" ? 'selected':''?>>18:30</option>
            <option <?=isset($cita) && substr($cita[0]["fechahora"], 11,5) == "19:00" ? 'selected':''?>>19:00</option>
            <option <?=isset($cita) && substr($cita[0]["fechahora"], 11,5) == "19:30" ? 'selected':''?>>19:30</option>            
        </select>            
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-10 col-sm-2">
          <button type="submit" class="btn btn-default">Guardar</button>
        </div>
    </div>    
</form>

<script>
      $(function() {
        $( '#datepicker' ).datepicker({
            altField: '[name="appointment[fecha]"]',
            altFormat: "m/d/yy"
        });
      });
</script>