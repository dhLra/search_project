window.addEventListener('load', function() {

  // Ordenar tabela de acordo com a coluna
  document.querySelectorAll(".provedores th").forEach(function (el, i) {
    el.addEventListener("click", function(event) {
      document.querySelectorAll(".provedores th:not(:nth-child(" + (i + 1) + "))")
        .forEach(function(th) {
          th.removeAttribute("order");
        });
      let tdIndex = i;

      if (i == 1 || i == 3) {
        tdIndex++;
      }

      let order = event.target.getAttribute("order") || "desc";

      if (order == "asc") {
        order = "desc";
      } else {
        order = "asc";
      }

      let rows = Array.from(
        document.querySelectorAll(".provedores tbody tr")
      ).sort(function(rowA, rowB) {
        let valA = rowA.querySelector("td:nth-child(" + (tdIndex + 1) + ") button").innerText;
        let valB = rowB.querySelector("td:nth-child(" + (tdIndex + 1) + ") button").innerText;

        if (order == "desc") {
          return (valB+"").localeCompare(valA + "");
        } else if (order == "asc") {
          return (valA+"").localeCompare(valB + "");
        }
      }).map(function(a) {
        return "<tr>" + a.innerHTML + "</tr>";
      });

      document.querySelector(".provedores tbody").innerHTML =
        rows.join(" ");

      event.target.setAttribute("order", order);
    })
  })
});
