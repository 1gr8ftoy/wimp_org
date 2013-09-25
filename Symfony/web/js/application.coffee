$(document).ready ->
  $(".radioset").buttonset()
  $("input[type=\"submit\"], button[type=\"submit\"]").button()
  $("#flash_alert").addClass("ui-state-error").addClass "ui-corner-bottom"
  $(".ui-state-highlight").prepend "<span class=\"ui-icon ui-icon-info\" style=\"float: left; margin-right: 1em;\"></span>"
  $(".ui-state-error").prepend "<span class=\"ui-icon ui-icon-alert\" style=\"float: left; margin-right: 1em;\"></span><strong>Alert:</strong> "
  $(".ui-state-error, .ui-state-highlight").wrapInner "<div style=\"display: inline-block;\" />"

  $("#search_dialog").dialog
    autoOpen:false,
    autoResize:true,
    width:350,
    modal:true,
    buttons:
      "Search":
        text: "Search",
        id: "submit_search_form",
        click: ->
          $('#search_dialog form').submit()

      ,
      "Reset Fields": ->
        $('#search_dialog form input').val ''
      ,
      Cancel: ->
        $(this).dialog "close"
    ,
    close: ->
#      allFields.val("").removeClass "ui-state-error"

    $("#search_button").button().click ->
      $("#search_dialog").dialog "open"

    $("#reset_search").button()

    $("#form_searchStartDate").datepicker
      defaultDate: "-1w",
      changeMonth: true,
      numberOfMonths: 1,
      onClose: (selectedDate) ->
        $("#form_searchEndDate").datepicker("option", "minDate", selectedDate)

    $("#form_searchEndDate").datepicker
      changeMonth: true,
      numberOfMonths: 1,
      onClose: (selectedDate) ->
        $("#form_searchStartDate").datepicker("option", "maxDate", selectedDate)

  # Clear any pet image removal checkbox
  $("input[id*=deletePetImage]").removeAttr('checked')

@getParameter = (paramName) ->
  searchString = window.location.search.substring(1)
  i = undefined
  val = undefined
  params = searchString.split("&")
  i = 0
  while i < params.length
    val = params[i].split("=")
    return unescape(val[1])  if val[0] is paramName
    i++
  null