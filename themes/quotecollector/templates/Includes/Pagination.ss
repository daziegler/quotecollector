<% if $Results.MoreThanOnePage %>
    <ul class="pagination">
        <% if $Results.NotFirstPage %>
            <li>
                <a href="$Results.PrevLink"><i class="fa fa-chevron-left"></i></a>
            </li>
        <% end_if %>

        <% loop $Results.PaginationSummary %>
            <% if $Link %>
                <li <% if $CurrentBool %>class="active"<% end_if %>>
                    <a href="$Link">$PageNum</a>
                </li>
            <% else %>
                <li>...</li>
            <% end_if %>
        <% end_loop %>

        <% if $Results.NotLastPage %>
            <li>
                <a href="$Results.NextLink"><i class="fa fa-chevron-right"></i></a>
            </li>
        <% end_if %>
    </ul>
<% end_if %>