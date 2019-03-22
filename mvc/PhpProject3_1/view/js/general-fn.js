function form_delete(form_id) {
    if (confirm("Delete?")) {
      document.getElementById(form_id).submit();
    }
}

function form_reset(form_id) {
    document.getElementById(form_id).submit();
}
