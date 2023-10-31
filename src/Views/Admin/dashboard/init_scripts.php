<?= asset_link('admin/js/apexcharts.js', 'js') ?>
<script>
     document.addEventListener("alpine:init", () => {
        // total-visit
        Alpine.data("core_dashboard", () => ({
            init() {
                isDark = this.$store.app.theme === "dark" || this.$store.app.isDarkMode ? true : false;
                isRtl = this.$store.app.rtlClass === "rtl" ? true : false;

                const totalVisit = null;
                const paidVisit = null;
                const uniqueVisitorSeries = null;
                const followers = null;
                const referral = null;
                const engagement = null;

                // statistics
                setTimeout(() => {
                    this.totalVisit = new ApexCharts(this.$refs.totalVisit, this.totalVisitOptions);
                    this.totalVisit.render();

                }, 300);

                this.$watch('$store.app.theme', () => {
                    isDark = this.$store.app.theme === "dark" || this.$store.app.isDarkMode ? true : false;
                    this.totalVisit.updateOptions(this.totalVisitOptions);
                    this.paidVisit.updateOptions(this.paidVisitOptions);
                    this.uniqueVisitorSeries.updateOptions(this.uniqueVisitorSeriesOptions);
                    this.followers.updateOptions(this.followersOptions);
                    this.referral.updateOptions(this.referralOptions);
                    this.engagement.updateOptions(this.engagementOptions);
                });

                this.$watch('$store.app.rtlClass', () => {
                    isRtl = this.$store.app.rtlClass === "rtl" ? true : false;
                    this.uniqueVisitorSeries.updateOptions(this.uniqueVisitorSeriesOptions);
                });
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