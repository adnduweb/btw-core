import Alpine from 'alpinejs';
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import interaction from '@fullcalendar/interaction';

Alpine.data('calendar', () => ({
    defaultParams: {
        id: null,
        title: '',
        start: '',
        end: '',
        description: '',
        type: 'primary',
    },
    params: {
        id: null,
        title: '',
        start: '',
        end: '',
        description: '',
        type: 'primary',
    },
    isAddEventModal: false,
    minStartDate: '',
    minEndDate: '',
    calendar: null,
    now: new Date(),
    calendarUrlEvent: '',
    events: [],
    init() {

        var calendarEl = document.getElementById('calendar');
        this.calendarConfig = JSON.parse(calendarEl.getAttribute('data-event-calendar-config'));

        this.events = calendarEl.getAttribute('data-event-calendar');
        if(this.events != undefined){
            this.events = JSON.parse(this.events);
        }

        this.calendar = new Calendar(this.$refs.calendar, {
            plugins: [ dayGridPlugin, timeGridPlugin, listPlugin, interaction ],
            initialView: 'dayGridMonth',
            
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay',
            },
            editable: true,
            dayMaxEvents: true,
            selectable: true,
            droppable: true,
            locale: 'fr',
            eventClick: (event) => {
                console.log('fgdsfgsfdgsdfgdsfg');
                this.editEvent(event);
            },
            select: (event) => {
                this.editDate(event);
            },
            events: this.events,
            eventDrop: function(info, delta, revertFunc) {
                var start = (info.event.start) ? info.event.start.toISOString() : 'null';
                var end = (info.event.end) ? info.event.end.toISOString() : 'null';

                event = {
                    id: info.event.id,
                    to: end,
                    from: start
                }
                this.calendarUrlEvent = calendarEl.getAttribute('data-event-url');
                htmx.ajax('POST', this.calendarUrlEvent, {
                    values: event
                }).then(() => {
                    console.log('Content drag/drop successfully!');
                });

            }
        });
        this.calendar.render();

        this.$watch('$store.app.sidebar', () => {
            setTimeout(() => {
                this.calendar.render();
            }, 300);
        });
    },

    getMonth(dt, add = 0) {
        let month = dt.getMonth() + 1 + add;
        return dt.getMonth() < 10 ? '0' + month : month;
    },

    editEvent(data) {

        this.params = JSON.parse(JSON.stringify(this.defaultParams));
        if (data) {
            let type = '';
            let badges = this.calendarConfig.badges;
            let obj = JSON.parse(JSON.stringify(data.event));
            this.params = {
                id: obj.id ? obj.id : null,
                title: obj.title ? obj.title : null,
                start: this.dateFormat(obj.start),
                end: this.dateFormat(obj.end),
                //type: type,
                type: obj.classNames ? obj.classNames[0] : 'primary',
                description: obj.extendedProps ? obj.extendedProps.description : '',
            };
            this.minStartDate = new Date();
            this.minEndDate = this.dateFormat(obj.start);
        } else {
            this.minStartDate = new Date();
            this.minEndDate = new Date();
        }

        this.isAddEventModal = true;
    },

    editDate(data) {
        let obj = {
            event: {
                start: data.start,
                end: data.end,
            },
        };
        this.editEvent(obj);
    },

    dateFormat(dt) {
        dt = new Date(dt);
        const month = dt.getMonth() + 1 < 10 ? '0' + (dt.getMonth() + 1) : dt.getMonth() + 1;
        const date = dt.getDate() < 10 ? '0' + dt.getDate() : dt.getDate();
        const hours = dt.getHours() < 10 ? '0' + dt.getHours() : dt.getHours();
        const mins = dt.getMinutes() < 10 ? '0' + dt.getMinutes() : dt.getMinutes();
        dt = dt.getFullYear() + '-' + month + '-' + date + 'T' + hours + ':' + mins;
        return dt;
    },

    saveEvent() {
        if (!this.params.title) {
            return true;
        }
        if (!this.params.start) {
            return true;
        }
        if (!this.params.end) {
            return true;
        }

        if (this.params.id) {
            //update event
            let event = this.events.find((d) => d.id == this.params.id);
            event.title = this.params.title;
            event.start = this.params.start;
            event.end = this.params.end;
            event.description = this.params.description;
            event.className = this.params.type;
        } else {
            //add event
            let maxEventId = 0;
            if (this.events) {
                maxEventId = this.events.reduce((max, character) =>
                    (character.id > max ? character.id : max), 
                    1);
            }

            let event = {
                id: maxEventId + 1,
                title: this.params.title,
                start: this.params.start,
                end: this.params.end,
                description: this.params.description,
                className: this.params.type,
            };
            
            this.events.push(event);
        }
        this.calendar.getEventSources()[0].refetch(); //refresh Calendar
        // this.showMessage('Event has been saved successfully.');
        this.isAddEventModal = false;
        
    },

    startDateChange(event) {
        const dateStr = event.target.value;
        if (dateStr) {
            this.minEndDate = this.dateFormat(dateStr);
            this.params.end = '';
        }
    },

    showMessage(msg = '', type = 'success') {
        const toast = window.Swal.mixin({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 3000,
        });
        toast.fire({
            icon: type,
            title: msg,
            padding: '10px 20px',
        });
    },
}));
 