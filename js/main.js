window.addEventListener('load', function () {
  var input = document.querySelector("#busca")
  var select = document.querySelector("select[name=type]")

  function updateInputDataList (typeCode) {
    switch (typeCode) {
      case "4":
        input.setAttribute('list', "cities");
        break;
      case "2":
        input.setAttribute('list', "razao-social");
        break;
      case "7":
        input.setAttribute('list', "providers");
        break;
      default:
        input.setAttribute('list', "");
    }
  }

  select.addEventListener('change', function(e) {
    updateInputDataList(e.target.value);
  });

  updateInputDataList(select.value);


});
