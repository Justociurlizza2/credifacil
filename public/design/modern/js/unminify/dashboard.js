// console.clear();
function initCharts(data, xlabels) {
    console.log('init-Chart', data)
    window.Apex = { chart: { parentHeightOffset: 0, toolbar: { show: !1 } }, grid: { padding: { left: 0, right: 0 } }, colors: ["#727cf5", "#0acf97", "#fa5c7c", "#ffbc00"] };
    var e = ["#727cf5", "#0acf97", "#fa5c7c", "#ffbc00"],
        t = $("#revenue-chart").data("colors");
    t && (e = t.split(","));
    var r = {
        chart: { height: 364, type: "line", dropShadow: { enabled: !0, opacity: 0.2, blur: 7, left: -7, top: 7 } },
        dataLabels: { enabled: !1 },
        stroke: { curve: "smooth", width: 4 },
        series: data,
        colors: e,
        zoom: { enabled: !1 },
        legend: { show: !1 },
        xaxis: { type: "string", categories: xlabels, tooltip: { enabled: !1 }, axisBorder: { show: !1 } },
        yaxis: {
            labels: {
                formatter: function (e) {
                    // return e + "k";
                    return "s/ "+ e;
                },
                offsetX: -15,
            },
        },
    };
    new ApexCharts(document.querySelector("#revenue-chart"), r).render();
}

function printBars (xlabs, data) {
    (dataColors = $("#datalables-bar").data("colors")) && (colors = dataColors.split(","));
    options = {
        chart: { height: 450, type: "bar" },
        plotOptions: { bar: { barHeight: "100%", distributed: !0, horizontal: !0, dataLabels: { position: "bottom" } } },
        colors: colors,
        dataLabels: {
            enabled: !0,
            textAnchor: "start",
            style: { colors: ["#fff"] },
            formatter: function (e, t) {
                return t.w.globals.labels[t.dataPointIndex] + ":  " + e;
            },
            offsetX: 0,
            dropShadow: { enabled: !1 },
        },
        series: [{ data: data }],
        stroke: { width: 0, colors: ["#fff"] },
        xaxis: { categories: xlabs },
        yaxis: { labels: { show: !1 } },
        grid: { borderColor: "#f1f3fa" },
        tooltip: {
            theme: "dark",
            x: { show: !1 },
            y: {
                title: {
                    formatter: function () {
                        return "";
                    },
                },
            },
        },
    };
    (chart = new ApexCharts(document.querySelector("#datalables-bar"), options)).render();
}

function simplePie (xlabs, data) {
    var colors = $("#simple-pie").data("colors");
    colors = colors.split(",");
    var options = {
        chart: {
            height: 360,
            type: "pie"
        },
        series: data,
        labels: xlabs,
        colors: colors,
        legend: {
            show: !0,
            position: "bottom",
            horizontalAlign: "center",
            verticalAlign: "middle",
            floating: !1,
            fontSize: "14px",
            offsetX: 0,
            offsetY: 7
        },
        responsive: [{
            breakpoint: 600,
            options: {
                chart: {
                    height: 240
                },
                legend: {
                    show: !1
                }
            }
        }]
    }
      , chart = new ApexCharts(document.querySelector("#simple-pie"),options);
    chart.render();
}

function fdonut (xlabs, data) {
    console.log('fdonut', xlabs)
    var colors = $("#simple-donut").data("colors");
    colors = colors.split(",");
    options = {
        chart: {
            height: 380,
            type: "donut"
        },
        series: data,
        legend: {
            show: !0,
            position: "bottom",
            horizontalAlign: "center",
            verticalAlign: "middle",
            floating: !1,
            fontSize: "14px",
            offsetX: 0,
            offsetY: 7
        },
        labels: xlabs,
        colors: colors,
        responsive: [{
            breakpoint: 600,
            options: {
                chart: {
                    height: 240
                },
                legend: {
                    show: !1
                }
            }
        }]
    };
    (chart = new ApexCharts(document.querySelector("#simple-donut"),options)).render();
}

function termoBar (xlabs, data0, data1) {
    var colors = $("#negative-bar").data("colors");
    colors = colors.split(",");
    options = {
        chart: { height: 380, type: "bar", stacked: !0, toolbar: { show: !1 } },
        colors: colors,
        plotOptions: { bar: { horizontal: !0, barHeight: "80%" } },
        dataLabels: { enabled: !1 },
        stroke: { width: 1, colors: ["#fff"] },
        series: [
            { name: "Más rentables", data: data0 },
            { name: "Menos rentables", data: data1 },
        ],
        grid: { borderColor: "#f1f3fa", padding: { bottom: 5 } },
        yaxis: { min: -33, max: 150, title: {} },
        tooltip: {
            shared: !1,
            x: {
                formatter: function (e) {
                    return e;
                },
            },
            y: {
                formatter: function (e) {
                    return Math.abs(e) + "%";
                },
            },
        },
        xaxis: {
            categories: xlabs,
            title: { text: "Percent" },
            labels: {
                formatter: function (e) {
                    return Math.abs(Math.round(e)) + "%";
                },
            },
        },
        legend: { offsetY: 7 },
    };
    (chart = new ApexCharts(document.querySelector("#negative-bar"), options)).render();
}

















var briteChartApp = window.briteChartApp || {};
function createHorizontalBarChart(e, t) {
    "use strict";
    var c = ["#727cf5", "#0acf97", "#6c757d", "#fa5c7c", "#ffbc00", "#39afd1", "#e3eaef"];
    var 
        a = i(e).data("colors"),
        l = a ? a.split(",") : c.concat(),
        n = new britecharts.bar(),
        u = d3.select(e),
        o = !!u.node() && u.node().getBoundingClientRect().width,
        r = !!u.node() && u.node().getBoundingClientRect().height;
    n.colorSchema(l).isAnimated(!0).isHorizontal(!0).width(o).margin({ top: 10, left: 50, bottom: 20, right: 10 }).enableLabels(!0).percentageAxisToMaxRatio(1.3).labelsNumberFormat(1).height(r), u.datum(t).call(n);

    function i () {
        var e = [
                { name: "Mon", value: 2100 },
                { name: "Tue", value: 5001 },
                { name: "Wed", value: 4000 },
                { name: "Thu", value: 5500 },
                { name: "Fri", value: 7500 },
                { name: "Sat", value: 4500 },
                { name: "Sun", value: 3500 },
            ];
            const u = () => {
                d3.selectAll(".bar-chart").remove(),
                    d3.selectAll(".line-chart").remove(),
                    d3.selectAll(".donut-chart").remove(),
                    d3.selectAll(".britechart-legend").remove(),
                    d3.selectAll(".brush-chart").remove(),
                    d3.selectAll(".step-chart").remove(),
                    0 < i(".bar-container").length && briteChartApp.createBarChart(".bar-container", e),
                    0 < i(".bar-container-horizontal").length && briteChartApp.createHorizontalBarChart(".bar-container-horizontal", e)
                    0 < i(".line-container").length && briteChartApp.createLineChart(".line-container", t),
                    0 < i(".donut-container").length && briteChartApp.createDonutChart(".donut-container", a),
                    0 < i(".brush-container").length && briteChartApp.createBrushChart(".brush-container", l),
                    0 < i(".step-container").length && briteChartApp.createStepChart(".step-container", n);
            }
            // i(window).on("resize", function (e) {
            //     e.preventDefault(), setTimeout(u, 200);
            // })
            //     u();
    }

}
// (jQuery, briteChartApp)