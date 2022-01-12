var chartColors = {
  color0: "#F2B705",
  color1: "#F29F05",
  color2: "#F24405",
  color3: "#049DD9",
};

var topChartMaxValue = 50;

var charts = {};

var UF_COMPLEMENTS = {
  path4978: "path4938",
};

var SVG_UF = {
  // Norte
  AC: "path5046",
  AM: "path5000",
  RR: "path4936",
  RO: "path5076",
  PA: "path4978",
  AP: "path4918",
  TO: "path5096",

  // Centro-Oeste
  MT: "path5126",
  MS: "path5246",
  GO: "path5168",
  DF: "path5098",

  // Sul
  PR: "path5284",
  SC: "path5294",
  RS: "path5334",

  // Sudeste
  SP: "path5270",
  MG: "path5192",
  RJ: "path5200",
  ES: "path5172",

  // Nordeste
  BA: "path5140",
  SE: "path5050",
  AL: "path5036",
  PE: "path4982",
  PB: "path4964",
  RN: "path4948",
  CE: "path4962",
  PI: "path5032",
  MA: "path5020",
};

var SVG_REGIAO = {
  'Norte': [
    "path5046",
    "path5000",
    "path4936",
    "path5076",
    "path4978",
    "path4918",
    "path5096",
  ],
  'Centro-Oeste': [
    "path5126",
    "path5246",
    "path5168",
    "path5098",
  ],
  'Sul': [
    "path5284",
    "path5294",
    "path5334",
  ],
  'Sudeste': [
    "path5270",
    "path5192",
    "path5200",
    "path5172",
  ],
  'Nordeste': [
    "path5140",
    "path5050",
    "path5036",
    "path4982",
    "path4964",
    "path4948",
    "path4962",
    "path5032",
    "path5020",
  ],
};

function findCity(cityName) {
  for (let i = 0; i < allCities.length; i++) {
    if (allCities[i].cidade == cityName) {
      return allCities[i];
    }
  }

  return {};
}

function highlightRegion(region) {
  if (!SVG_REGIAO[region]) {
    return;
  }

  document.querySelectorAll("svg path").forEach(function (node) {
    node.classList.add("in_highlight");
  })

  SVG_REGIAO[region].forEach(function (item) {
    let regiaoEl = document.querySelector("#"+item);
    svgz_element(regiaoEl).toTop();
  });

  setTimeout(function() {
      SVG_REGIAO[region].forEach(function (item) {
        let regiaoEl = document.querySelector("#"+item);
        let ufElComplement = null;

        if (UF_COMPLEMENTS[item]) {
          ufElComplement = document.querySelector("#" + UF_COMPLEMENTS[item]);
          ufElComplement.classList.add("highlighted");
        }

        regiaoEl.classList.add("highlighted");
      });
  }, 50);
}

function highlightState(uf) {
  if (!SVG_UF[uf]) {
    return;
  }

  document.querySelectorAll("svg path").forEach(function (node) {
    node.classList.add("in_highlight");
  })

  let ufEl = document.querySelector("#"+SVG_UF[uf]);
  let ufElComplement = null;

  if (UF_COMPLEMENTS[SVG_UF[uf]]) {
    ufElComplement = document.querySelector("#" + UF_COMPLEMENTS[SVG_UF[uf]]);
  }

  svgz_element(ufEl).toTop();
  if (ufElComplement) {
    svgz_element(ufElComplement).toTop();
  }

  setTimeout(function() {
    ufEl.classList.add("highlighted");
    if (ufElComplement) {
      ufElComplement.classList.add("highlighted");
    }
  }, 50);
}

function dehighlightPaths() {
  document.querySelectorAll("svg path").forEach(function (node) {
    node.classList.remove("highlighted");
    node.classList.remove("in_highlight");
  })
}

window.addEventListener('load', function () {
  let regionSelect = document.querySelector("select[name=regiao]");
  let stateSelect = document.querySelector("select[name=uf]");
  let cityInput = document.querySelector("input[name=cidade]");

  regionSelect.addEventListener("change", function(event) {
    dehighlightPaths();
    highlightRegion(event.target.value);
    stateSelect.value = "";
  });

  stateSelect.addEventListener("change", function(event) {
    dehighlightPaths();
    highlightState(event.target.value);
    regionSelect.value = "";
  });

  cityInput.addEventListener("change", function(event) {
    let state = findCity(event.target.value).estado;
    if (state) {
      dehighlightPaths();
      highlightState(state);
      if (state != stateSelect.value) {
        stateSelect.value = "";
      }
    }
  })

  highlightRegion(regionSelect.value);
  highlightState(stateSelect.value);


  Object.keys(SVG_UF).forEach(function(uf) {
    let ufCell = document.querySelector("#" + SVG_UF[uf]);

    ufCell.addEventListener("click", function() {
      stateSelect.value = uf;
      regionSelect.value = "";
      dehighlightPaths();
      highlightState(uf);
      updateUFStatistics(uf);
    });

    if (UF_COMPLEMENTS[SVG_UF[uf]]) {
      let ufCellComplement = document.querySelector("#" + UF_COMPLEMENTS[SVG_UF[uf]]);
      ufCellComplement.addEventListener("click", function() {
        stateSelect.value = uf;
        regionSelect.value = "";
        dehighlightPaths();
        highlightState(uf);
        updateUFStatistics(uf);
      });
    }
  });

  // Async data requests
  stateSelect.addEventListener("change", function(event) {
    if (!event.target.value) return;

    updateUFStatistics(event.target.value);
  });

  regionSelect.addEventListener("change", function(event) {
    if (!event.target.value) return;

    updateRegionStatistics(event.target.value);
  });

  cityInput.addEventListener("change", function(event) {
    updateCityStatistics(event.target.value);
  });

  setupCharts();

  updateProviderTotalSign(totalProvider);

  updateActiveCircuitCityStatistics();
  updateCoverageAreaStatistics();
  updateHomologatedProvidersStatistics();
});


function updateProviderTotalSign(total) {
  document.querySelector("#provider-total").textContent = total;
}

function updateSecondProviderTotalSign(total, text) {
  let el = document.querySelector("#second-provider-total");
  document.querySelector('#second-provider-total-card').style.visibility = 'visible';
  el.innerHTML = text + ' ' + total;
  el.style.display = 'block';
}

function updateCityStatistics(city) {
  fetch("/controller.php", {
    method: "POST",
    headers: {
      'Content-Type': "application/json",
    },
    body: JSON.stringify({
      action: "statistic/provider/city",
      city: city,
    }),
  }).then(function (body) {
    body.json().then(function (data) {
      let totalProvider = parseFloat(data.provider);
      updateProviderChart(parseFloat(data.asn), parseFloat(data.isp));
      updateSecondProviderTotalSign(totalProvider, "Total da cidade");
    });
  });

  let c = findCity(city);
  if (c.estado) {
    updateActiveCircuitCityUfStatistics(c.estado);
    updateCoverageAreaUFStatistics(c.estado);
  }
}

function updateUFStatistics(uf) {
  fetch("/controller.php", {
    method: "POST",
    headers: {
      'Content-Type': "application/json",
    },
    body: JSON.stringify({
      action: "statistic/provider/uf",
      uf: uf,
    }),
  }).then(function (body) {
    body.json().then(function (data) {
      let totalProvider = parseFloat(data.provider);
      updateProviderChart(parseFloat(data.asn), parseFloat(data.isp));
      updateSecondProviderTotalSign(totalProvider, "Total do <wbr/>estado:<wbr/>");
    });
  });

  updateActiveCircuitCityUfStatistics(uf);
  updateCoverageAreaUFStatistics(uf);
  updateHomologatedProvidersUFStatistics(uf);
}

function updateRegionStatistics(region) {
  fetch("/controller.php", {
    method: "post",
    headers: {
      'content-type': "application/json",
    },
    body: JSON.stringify({
      action: "statistic/provider/region",
      region: region,
    }),
  }).then(function (body) {
    body.json().then(function (data) {
      let totalProviderRegion = parseFloat(data.provider);
      updateProviderChart(parseFloat(data.asn), parseFloat(data.isp));
      updateSecondProviderTotalSign(totalProviderRegion, "total da <wbr/>região:<wbr/>");
    });
  });

  updateActiveCircuitCityRegionStatistics(region);
  updateCoverageAreaRegionStatistics(region);
  updateHomologatedProvidersRegionStatistics(region);
}

function updateActiveCircuitCityStatistics() {
  fetch("/controller.php", {
    method: "post",
    headers: {
      'content-type': "application/json",
    },
    body: JSON.stringify({
      action: "statistic/city/circuit-active",
      city: "",
    }),
  }).then(function (body) {
    body.json().then(function (data) {
      let circuits = data.circuits.slice(0, topChartMaxValue);
      updateActiveCircuitChart(
        circuits.map(function (a) {
          return a.cidade;
        }),
        circuits.map(function (a) {
          return a.circuitos;
        }
      ));
    });
  });
}

function updateActiveCircuitCityRegionStatistics(region) {
  fetch("/controller.php", {
    method: "post",
    headers: {
      'content-type': "application/json",
    },
    body: JSON.stringify({
      action: "statistic/region-city/circuit-active",
      region: region,
    }),
  }).then(function (body) {
    body.json().then(function (data) {
      let circuits = data.circuits.slice(0, 20);
      updateActiveCircuitChart(
        circuits.map(function (a) {
          return a.cidade;
        }),
        circuits.map(function (a) {
          return a.circuitos;
        }
      ));
    });
  });
}


function updateActiveCircuitCityUfStatistics(uf) {
  fetch("/controller.php", {
    method: "post",
    headers: {
      'content-type': "application/json",
    },
    body: JSON.stringify({
      action: "statistic/uf-city/circuit-active",
      uf: uf,
    }),
  }).then(function (body) {
    body.json().then(function (data) {
      let circuits = data.circuits.slice(0, 20);
      updateActiveCircuitChart(
        circuits.map(function (a) {
          return a.cidade;
        }),
        circuits.map(function (a) {
          return a.circuitos;
        }
      ));
    });
  });
}

function updateCoverageAreaStatistics() {
  fetch("/controller.php", {
    method: "post",
    headers: {
      'content-type': "application/json",
    },
    body: JSON.stringify({
      action: "statistic/city/area-coverage",
    }),
  }).then(function (body) {
    body.json().then(function (data) {
      let cities = data.cities.slice(0, topChartMaxValue);
      updateCoverageAreaChart(
        cities.map(function (a) {
          return a.cidade;
        }),
        cities.map(function (a) {
          return a.fornecedores;
        }
      ));
    });
  });
}

function updateCoverageAreaRegionStatistics(region) {
  fetch("/controller.php", {
    method: "post",
    headers: {
      'content-type': "application/json",
    },
    body: JSON.stringify({
      action: "statistic/region-city/area-coverage",
      region: region,
    }),
  }).then(function (body) {
    body.json().then(function (data) {
      let cities = data.cities.slice(0, topChartMaxValue);
      updateCoverageAreaChart(
        cities.map(function (a) {
          return a.cidade;
        }),
        cities.map(function (a) {
          return a.fornecedores;
        }
      ));
    });
  });
}

function updateCoverageAreaUFStatistics(uf) {
  fetch("/controller.php", {
    method: "post",
    headers: {
      'content-type': "application/json",
    },
    body: JSON.stringify({
      action: "statistic/uf-city/area-coverage",
      uf: uf,
    }),
  }).then(function (body) {
    body.json().then(function (data) {
      let cities = data.cities.slice(0, topChartMaxValue);
      updateCoverageAreaChart(
        cities.map(function (a) {
          return a.cidade;
        }),
        cities.map(function (a) {
          return a.fornecedores;
        }
      ));
    });
  });
}

function updateHomologatedProvidersUFStatistics(uf) {
  fetch("/controller.php", {
    method: "post",
    headers: {
      'content-type': "application/json",
    },
    body: JSON.stringify({
      action: "statistic/uf-provider/homologated",
      uf: uf,
    }),
  }).then(function (body) {
    body.json().then(function (data) {
      updateHomologatedProvidersList(data.homologated);
    });
  });
}


function updateHomologatedProvidersRegionStatistics(region) {
  fetch("/controller.php", {
    method: "post",
    headers: {
      'content-type': "application/json",
    },
    body: JSON.stringify({
      action: "statistic/region-provider/homologated",
      region: region,
    }),
  }).then(function (body) {
    body.json().then(function (data) {
      updateHomologatedProvidersList(data.homologated);
    });
  });
}

function updateHomologatedProvidersStatistics() {
  fetch("/controller.php", {
    method: "post",
    headers: {
      'content-type': "application/json",
    },
    body: JSON.stringify({
      action: "statistic/provider/homologated",
    }),
  }).then(function (body) {
    body.json().then(function (data) {
      updateHomologatedProvidersList(data.homologated);
    });
  });
}

function setupCharts() {
  Chart.defaults.color = "#fff";
  Chart.defaults.borderColor = "#B2ABAC";

  initProviderChart();
  initActiveCircuitChart();
  initAreaCoverageChart();
  updateProviderChart(totalASN, totalISP);
}

var asn_isp_data = {
  labels: [
    "ASNs",
    "ISPs"
  ],
  datasets: [{
    data: [],
    hoverOffset: 4,
    backgroundColor: [
      chartColors.color2,
      chartColors.color0
    ],
    borderWidth: 0,
    borderSkipped: false,
  }]
};

var circuit_active_data = {
  labels: [],
  datasets: [{
    label: "Top cidades com circuitos ativos",
    data: [],
    hoverOffset: 4,
    backgroundColor: [
      chartColors.color2,
      chartColors.color0,
    ],
  }],
};

var area_coverage_data = {
  labels: [],
  datasets: [{
    axis: 'y',
    fill: false,
    label: "Top área de cobertura de fornecedores por cidade",
    data: [],
    hoverOffset: 4,
    backgroundColor: [
      chartColors.color2,
      chartColors.color3,
      chartColors.color0,
    ],
  }],
};

function initProviderChart() {
  let asnCtx = document.getElementById("provider-chart").getContext("2d");

  charts.provider = new Chart(asnCtx, {
    type: 'doughnut',
    data: asn_isp_data,
  });
}

function initActiveCircuitChart() {
  let circuitCtx = document.getElementById("active-circuit-chart").getContext("2d");

  charts.activeCircuit = new Chart(circuitCtx, {
    type: 'bar',
    data: circuit_active_data,
    options: {
      scale: {
        ticks: {
          precision: 0
        }
      },
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  })
}

function initAreaCoverageChart() {
  let coverageCtx = document.getElementById("area-coverage-chart").getContext("2d");

  charts.coverageArea = new Chart(coverageCtx, {
    type: 'bar',
    data: area_coverage_data,
    options: {
      indexAxis: 'y',
      scale: {
        ticks: {
          precision: 0
        }
      },
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  })
}

function updateProviderChart(asn, isp) {
  charts.provider.data.datasets[0].data = [asn, isp];
  charts.provider.update();
}

function updateProviderChartData(data) {
  charts.provider.data = data;
  charts.provider.update();
}

function updateActiveCircuitChart(cities, circuits) {
  charts.activeCircuit.data.labels = cities;
  charts.activeCircuit.data.datasets[0].data = circuits;
  charts.activeCircuit.update();
}

function updateCoverageAreaChart(cities, providers) {
  charts.coverageArea.data.labels = cities;
  charts.coverageArea.data.datasets[0].data = providers;
  charts.coverageArea.update();
}

function updateHomologatedProvidersList(providers) {
  let el = document.getElementById("homologated-provider-list");

  el.innerHTML = `
    ${providers.map(function (p) {
      return `<li>${p.nome}</li>`
    }).join(' ')}
  `;
}
