<% if $Quotes %>
    <% loop $Quotes %>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <% if $QuoteHeader %>
                    <h2>$QuoteHeader</h2>
                <% end_if %>
                <p class="quoteContent">$QuoteContent</p>
                <br />
                <div class="originalAuthor">$OriginalAuthor</div>
                <% if $Tags %>
                    <ul>
                        <% loop $Tags %>
                            <li>$Title</li>
                        <% end_loop %>
                    </ul>
                <% end_if %>
            </div>
            <div class="col-md-1"></div>
        </div>
        <a href="{$Top.Link}delete/{$ID}">delete</a>
    <% end_loop %>
<% end_if %>