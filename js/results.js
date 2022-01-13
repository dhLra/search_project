window.addEventListener('load', function() {

  // Ordenar tabela de acordo com a coluna
  document.querySelectorAll(".provedores th").forEach(function (el, i) {
    el.addEventListener("click", function(event) {
      el.querySelector("form").submit();
    });
  })
});
