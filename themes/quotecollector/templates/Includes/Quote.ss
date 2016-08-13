<% if $Results %>
    <% loop $Results %>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <% if $QuoteHeader %>
                    <h2>$QuoteHeader</h2>
                <% end_if %>
                <p class="quoteContent">$QuoteContent</p>
                <br />
                <div class="originalAuthor">$OriginalAuthor</div>
                <div>$AdditionalInfo</div>
                <a href="{$Top.Link}delete/{$ID}">delete</a>
                <% if $Tags %>
                    <ul>
                        <% loop $Tags %>
                            <li>Tagtitel: $Title</li>
                        <% end_loop %>
                    </ul>
                <% end_if %>
            </div>
        </div>
    <% end_loop %>
<% else %>
    <div class="row">
        <div class="col-md-offset-6 col-md-1 center">
            <h1>NO RESULTS FOUND!</h1>
        </div>
    </div>
<% end_if %>