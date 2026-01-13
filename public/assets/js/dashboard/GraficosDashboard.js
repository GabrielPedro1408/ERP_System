class GraficosDashboard {
    constructor(options = {}) {
        this.canvasClientes = document.getElementById(options.clientesId || 'grafico-clientes');
        this.canvasFaturamento = document.getElementById(options.faturamentoId || 'grafico-contas-a-receber');
        this.charts = {};
    }

    init(data = {}) {
        this.renderClientes(data.mes_ano || [], data.total_clientes || []);
        this.renderFaturamento(data.mes_ano_faturamento || [], data.total_faturamento || []);
    }

    renderClientes(labels, dados) {
        if (!this.canvasClientes) return;
        if (this.charts.clientes) this.charts.clientes.destroy();

        this.charts.clientes = new Chart(this.canvasClientes, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Novos Clientes',
                    data: dados,
                    backgroundColor: ['#E18A52'],
                    borderColor: ['rgba(5, 62, 97, 0.733)'],
                    borderWidth: 1
                }]
            },
            options: {
                animations: {
                    tension: {
                        duration: 9000,
                        easing: 'easeInQuad',
                        from: 0.1,
                        to: 0.4,
                        loop: true
                    }
                },
                scales: {
                    y: { min: 0, max: 70 }
                }
            }
        });
    }

    renderFaturamento(labels, dados) {
        if (!this.canvasFaturamento) return;
        if (this.charts.faturamento) this.charts.faturamento.destroy();

        // se passado o elemento canvas, Chart pode receber diretamente
        this.charts.faturamento = new Chart(this.canvasFaturamento.getContext
            ? this.canvasFaturamento.getContext('2d')
            : this.canvasFaturamento, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Faturamento (R$)',
                    data: dados,
                    backgroundColor: ['#e18952a4'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: true } },
                scales: { y: { beginAtZero: true } }
            }
        });
    }
}

/* helper global para ser chamado a partir do PHP */
window.renderDashboardCharts = function(payload, options = {}) {
    const graficos = new GraficosDashboard(options);
    graficos.init(payload);
    return graficos;
};