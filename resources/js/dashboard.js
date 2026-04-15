import * as echarts from "echarts";
import { sigopSwal } from "./lib/swalTheme.js";

function verBodegasPorReferencia(referencia) {
    console.log("Buscando bodegas para:", referencia);

    fetch(`/admin/dashboard/bodegas/${referencia}`)
        .then(res => res.json())
        .then(registros => {

            let html = registros.map(b =>
                `<div class="sigop-swal-detail">
                    <strong>Descripción</strong> ${b.descripcion}<br>
                    <strong>Referencia</strong> ${b.referencia}<br>
                    <strong>Estado</strong> ${b.estado}
                </div>`
            ).join("");

            sigopSwal.fire({
                title: `Bodegas con referencia ${referencia}`,
                html: html,
                width: 600,
                confirmButtonText: "Cerrar",
                showCloseButton: true,
            });
        });
}


function verMaterialesPorItem(item) {
    fetch(`/admin/dashboard/materiales/${item}`)
        .then(res => res.json())
        .then(registros => {

            let html = registros.map(m =>
                `<div class="sigop-swal-detail">
                    <strong>Nombre</strong> ${m.nombre_material}<br>
                    <strong>Ítem</strong> ${m.item_material}<br>
                    <strong>Unidad</strong> ${m.unidad_medida}<br>
                    <strong>Estado</strong> ${m.estado}
                </div>`
            ).join("");

            sigopSwal.fire({
                title: `Materiales del ítem ${item}`,
                html: html,
                width: 600,
                confirmButtonText: "Cerrar",
                showCloseButton: true,
            });
        });
}

document.addEventListener("DOMContentLoaded", () => {

    const page = document.querySelector(".page");
    if (!page || page.dataset.seccion !== "dashboard") return;

    fetch("/admin/dashboard/data")
        .then(res => res.json())
        .then(data => {

            /* ===============================
            TARJETAS
            =============================== */
            document.querySelector("#bodegasActivas").textContent = data.totales.bodegas.activas;
            document.querySelector("#bodegasInactivas").textContent = data.totales.bodegas.inactivas;
            document.querySelector("#materialesActivos").textContent = data.totales.materiales.activas;
            document.querySelector("#materialesInactivos").textContent = data.totales.materiales.inactivas;


            /* ===============================
            CREAR LOS GRAFICOS PIE
            =============================== */

            function renderPie(id, activos, inactivos, titulo) {
                const dom = document.getElementById(id);
                const chart = echarts.init(dom);

                chart.setOption({
                    tooltip: {
                        trigger: 'item'
                    },
                    legend: {
                        top: '5%',
                        left: 'center'
                    },
                    series: [
                        {
                            name: titulo,
                            type: 'pie',
                            radius: ['40%', '70%'],
                            avoidLabelOverlap: false,
                            label: {
                                show: false,
                                position: 'center'
                            },
                            emphasis: {
                                label: {
                                    show: true,
                                    fontSize: 28,
                                    fontWeight: 'bold'
                                }
                            },
                            labelLine: {
                                show: false
                            },
                            data: [
                                {
                                    value: activos,
                                    name: 'Activos',
                                    itemStyle: { color: "rgba(0,200,0,0.9)" }
                                },
                                {
                                    value: inactivos,
                                    name: 'Inactivos',
                                    itemStyle: { color: "rgba(255,0,0,0.3)" }
                                }
                            ]
                        }
                    ]
                });
            }


            //Renderizar los graficos de torta
            renderPie("chartBodegasEstado", data.totales.bodegas.activas, data.totales.bodegas.inactivas, "Bodegas");
            renderPie("chartMaterialesEstado", data.totales.materiales.activas, data.totales.materiales.inactivas, "Materiales"
            );


            /* ===============================
            CREAR LOS GRAFICOS DE BARRAS
            =============================== */

            function renderBar(id, categorias, totales, colores, onClickBar) {
                const dom = document.getElementById(id);

                const chart = echarts.init(dom);

                chart.setOption({
                    tooltip: { trigger: "axis" },
                    grid: {
                        left: 40,
                        right: 20,
                        bottom: 100,
                        top: 20
                    },
                    xAxis: {
                        type: "category",
                        data: categorias,
                        axisLabel: {
                            rotate: -60,
                            fontSize: 10
                        }
                    },
                    yAxis: { type: "value" },
                    dataZoom: [
                        {
                            type: "slider",
                            start: 0,
                            end: categorias.length > 10 ? 20 : 100,
                        },
                        {
                            type: "inside"
                        }
                    ],
                    series: [{
                        type: "bar",
                        data: totales.map((v, i) => ({
                            value: v,
                            itemStyle: { color: colores[i] }
                        })),
                        barWidth: "60%"
                    }]
                });

                // ⚡ Evento click
                if (typeof onClickBar === "function") {
                    chart.on("click", (params) => {
                        onClickBar(params.name); // nombre = referencia o item
                    });
                }
            }


            //Remderozar los graficos de barras

            // Bodegas
            const refs = data.bodegasReferencias.map(b => b.referencia);
            const totalsRef = data.bodegasReferencias.map(b => b.total);
            const coloresRef = data.bodegasReferencias.map(b =>
                b.estado === "activo" ? "rgba(0,200,0,0.9)" : "rgba(255,0,0,0.3)"
            );

            renderBar("chartBodegas", refs, totalsRef, coloresRef,
                (referencia) => {
                    verBodegasPorReferencia(referencia)
                });

            // Materiales
            const items = data.materialesItems.map(m => m.item);
            const totalsMat = data.materialesItems.map(m => m.total);
            const coloresMat = data.materialesItems.map(m =>
                m.estado === "activo" ? "rgba(0,200,0,0.9)" : "rgba(255,0,0,0.3)"
            );

            renderBar("chartMateriales", items, totalsMat, coloresMat,
                (item) => {
                    verMaterialesPorItem(item);
                });
        });
});
