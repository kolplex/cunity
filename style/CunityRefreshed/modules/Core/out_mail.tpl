<table>
    <thead>
        <tr>
            <th style="padding:10px;text-align:left">
                <img src="http://cunity.net/img/logo.gif">
            </th>
            <th style="text-align:left">
                {-"mail_header"|setting}
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            {-include file="$tpl_name"}
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" style="padding:3px;font-size:11px;color:#999;text-align:right">
                {-"mail_footer"|setting}
            </td>
        </tr>
    </tfoot>
</table>