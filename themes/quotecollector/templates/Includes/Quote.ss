<% if $Results %>
    <div class="row">
        <div class="col-md-offset-4 col-md-4 center">
            <h3>Showing results $Results.FirstItem - $Results.LastItem ($Results.getTotalItems total)</h3>
        </div>
    </div>

    <div class="row">

    <%-- $CurrentMember.ID = $Quote.QuoteMemberID
    <% if $CurrentMember.ID == $QuoteMemberID %>
    <% else %>
        You Have no Quotes yet!
    <% end_if %>

     Needs to be finished, doesnt work
    --%>

    <% loop $Results %>
        <div class="col-md-offset-1 col-md-5 quoteWrapper">
            <% if $QuoteHeader %>
                <h2>$QuoteHeader</h2>
                <blockquote>
            <% else %>
                <blockquote class="noHeader">
            <% end_if %>
                <p>$QuoteContent</p>
                <footer>$OriginalAuthor
                    <% if $AdditionalInfo %>
                        in <cite title="Source Title">$AdditionalInfo</cite>
                    <% end_if %>
                </footer>
            </blockquote>
            <% if $Tags %>
                <ul class="list-inline">
                    <% loop $Tags %>
                        <li class="tag">$Title</li>
                    <% end_loop %>
                </ul>
            <% end_if %>
            <a href="{$Top.Link}delete/{$ID}">delete</a>
        </div>
    <% end_loop %>
<% else %>
    <div class="col-md-offset-5 col-md-3 center">
        <h1>NO RESULTS FOUND!</h1>
    </div>
<% end_if %>
