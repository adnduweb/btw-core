<?= asset_link('admin/js/apexcharts.js', 'js') ?>
<script >
     document.addEventListener("alpine:init", () => {
        // total-visit
        Alpine.data("coredashboard", () => ({
            init() {
                const totalVisit = null;

                // statistics
                setTimeout(() => {
                    this.totalVisit = new ApexCharts(this.$refs.totalVisit, this.totalVisitOptions);
                    this.totalVisit.render();

                }, 300);

            },

            // statistics
            get totalVisitOptions() {
                return {
                    series: [{
                        data: [21, 9, 36, 12, 44, 25, 59, 41, 66, 25]
                    }],
                    chart: {
                        height: 58,
                        type: 'line',
                        fontFamily: 'Nunito, sans-serif',
                        sparkline: {
                            enabled: true
                        },
                        dropShadow: {
                            enabled: true,
                            blur: 3,
                            color: '#009688',
                            opacity: 0.4
                        }
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 2
                    },
                    colors: ['#009688'],
                    grid: {
                        padding: {
                            top: 5,
                            bottom: 5,
                            left: 5,
                            right: 5
                        }
                    },
                    tooltip: {
                        x: {
                            show: false
                        },
                        y: {
                            title: {
                                formatter: formatter = () => {
                                    return '';
                                },
                            },
                        },
                    },
                }
            },
        }));
    });
</script>