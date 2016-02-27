<template id="dashboard-home">
   <div class="row">
       <div class="col-md-4">
           <h2>Schedule a Reminder</h2>
           {{-- New reminder form --}}
            <form class="reminder-form" @submit.prevent="handleReminderSubmit">
                <label><span class="number">1</span>Phone Number</label>
                <span class="error-message" v-if="validationErrors.no_recipient">
                    <strong>@{{ validationErrors.no_recipient }}</strong>
                </span>
                <div class="suggestion-wrapper">
                    <input  type="text" placeholder="International format" id="fi_search"
                            v-model="query"
                            @focus="showSuggestions = true"
                            @blur="showSuggestions = false"
                            @keyup.down.prevent="highlightContact"
                            @input="validate"
                            autocomplete="off"
                    >
                    {{-- Suggestion box to autocomplete contacts --}}
                    <div class="suggestionbox-wrapper" v-show="query.length > 1 && showSuggestions">
                        <div class="suggestionbox">
                            <p  v-for="contact in sharedState.contacts | filterBy query in 'name' 'number' | orderBy 'name' | limitBy 6"
                                @mousedown="selectContact(contact)"
                            >
                                @{{contact.name}} (@{{contact.number}})
                            </p>
                        </div>
                    </div>
                </div>

                <label><span class="number">2</span>Date &amp; time</label>
                <span class="error-message" v-if="validationErrors.send_datetime">
                    <strong>@{{ validationErrors.send_datetime }}</strong>
                </span>
                <input type="text" placeholder="DD/MM/YY hh:mm" v-model="newReminder.send_datetime" @input="validate">

                <label><span class="number">3</span>Message</label>
                <span class="error-message" v-if="validationErrors.message">
                    <strong>@{{ validationErrors.message }}</strong>
                </span>
                <textarea placeholder="Your message!" v-model="newReminder.message" @input="validate"></textarea>

                <label><span class="number">4</span>Repeat</label>
                <span class="error-message" v-if="validationErrors.repeat_id">
                    <strong>@{{ validationErrors.repeat_id }}</strong>
                </span>
                <select v-model="newReminder.repeat_id">
                    <option value="1">Never</option>
                    <option value="2">Daily</option>
                    <option value="3">Weekly</option>
                    <option value="4">Monthly</option>
                    <option value="5">Yearly</option>
                </select>

                <input type="submit" class="btn btn-submit" value="Submit">
            </form>
       </div>
        <div class="col-md-7 col-md-offset-1">
            <h2>Upcoming reminders</h2>
            <table class="upcoming-table">
                <thead>
                    <tr>
                        <th>To</th>
                        <th>Date &amp; time</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="reminder in remindersState.upcomingReminders | orderBy 'send_datetime'">
                        <td v-if="reminder.contact_id">
                            <span v-for="contact in sharedState.contacts | exactFilterBy reminder.contact_id in 'id'">
                                @{{ contact.name }}
                            </span>
                        </td>
                        <td v-else>@{{ reminder.recipient }}</td>
                        <td>@{{ reminder.send_datetime.substr(0, reminder.send_datetime.length-3) }}</td>
                        <td>@{{ reminder.message }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
