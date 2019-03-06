$(function () {
  
  var dateFormat = "mm/dd/yy",
    from = $("#from")
      .datepicker({
        showMeridian: true,
        autoClose: true,
        changeMonth:true,
        changeYear:true
      })
      .on("change", function () {
        var type = $('#type').val();
        to.datepicker("option", "minDate", getDate(this));
        if(type==3 || type=='3'){ // +1m after it's minDate if report's type = shipment tracking
          var s = this.value.split("/");
          var d = new Date(s[2],s[0],s[1]);
          d.setMonth(d.getMonth());
          to.datepicker("option", "maxDate", d); 
        }else{ // other than shipment tracking
          to.datepicker("option", "maxDate", null);
        }
      }),
    to = $("#to").datepicker({
      showMeridian: true,
      autoClose: true,
      minusStep: -3,
      orientation: "bottom right",
      changeMonth:true,
      changeYear:true
    })
      .on("change", function () {
        var type = $('#type').val();
        from.datepicker("option", "maxDate", getDate(this));
        if(type==3 || type=='3'){ // -1m after it's minDate if report's type = shipment tracking
          var s = this.value.split("/");
          var d = new Date(s[2],s[0],s[1]);
          d.setMonth(d.getMonth()-2);
          from.datepicker("option", "minDate", d); 
        }else{ // other than shipment tracking
          from.datepicker("option", "minDate", null);
        }
      });

  function getDate(element) {
    var date;
    try {
      date = $.datepicker.parseDate(dateFormat, element.value);
    } catch (error) {
      date = null;
    }
    return date;
  }

  $("#type").change(function () {
    var isgroup = document.getElementById('group');
    if(isgroup!=undefined){
      var group = $('#group').val(); 
    }else{
      var group = $('#groups').val();
    }
    
    group = encoding(group);

    getVendors(group, this.value);

    minMaxDatepicker($('#from'),null);
    minMaxDatepicker($('#to'),null);
    clearDateField();
  });

  function minMaxDatepicker(element, date){
    element.datepicker("option","minDate", date);
    element.datepicker("option","maxDate", date);
  }

  if(document.getElementById('groups')!=undefined){
    $('#groups').change(function(){
      group = encoding(this.value);
      report_type = $('#type').val();
      group = encoding(group);
      getVendors(group, report_type);
    });
  }

  function getVendors(group, report_type){
    var url = 'http://' + window.location.hostname + '/cilogin/prt/getVendors/' + group + "/" + report_type;
    //console.log(url);
    $("#vendors").empty()
      .append('<option value="">-- Choose Vendors --</option>')
    // Populate dropdown with list of vendors
    $.getJSON(url, function (data) {
      $.each(data, function (key, entry) {
        $("#vendors").append($('<option></option>').attr('value', entry.Vendors_SK).text(entry.Vendor_Name));
      });
    });
  }

  function clearDateField() {
      $('#from').val("");
      $('#to').val("");
  }


});