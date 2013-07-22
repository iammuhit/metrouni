<div class="container">

    {{ if departments_exist == false }}
        <p>There are no items.</p>
    {{ else }}
        <div class="items">
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <th>{{ helper:lang line="metrouni:department_name_label" }}</th>
                    <th>{{ helper:lang line="metrouni:department_email_label" }}</th>
                </tr>
                <!-- Here we loop through the $items array -->
                {{ departments }}
                <tr>
                    <td>{{ name }}</td>
                    <td>{{ email }}</td>
                </tr>
                {{ /departments }}
            </table>
        </div>

        {{ pagination:links }}

    {{ endif }}

</div>