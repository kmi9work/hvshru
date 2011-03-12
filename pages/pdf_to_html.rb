require 'rubygems'
require 'ruby-debug'
BEGIN{puts "<h1>#{gets.strip}</h1>\n\n<table align=\"left\">"}
END{puts'</table>'}

tab = "    "
puts  tab + "<tr>"
while gets    
  if $_ =~ /^\-\-(.*)/
    puts tab * 2 + '<tr>'
    puts tab * 3 + '<td valign="top" width="10px"></td>'
    puts tab * 3 + "<th>"
    puts tab * 4 + "<h5>#{$1.strip}<br><font size=\"3\">#{gets.strip}</font></h5>"
    puts tab * 3 + "</th>"
    puts tab * 2 + "</tr>"
  elsif $_ =~ /^\-(.*)/
    puts tab * 2 + '<tr>'
    puts tab * 3 + '<td valign="top" width="10px"></td>'
    puts tab * 3 + "<th>"
    puts tab * 4 + "<h5>#{$1.strip}</h5>"
    puts tab * 3 + "</th>"
    puts tab * 2 + "</tr>"
  elsif $_ =~ /^\=(.*)/
    puts tab * 2 + "<tr>"
    puts tab * 3 + '<td valign="top" width="10px"></td>'
    puts tab * 3 + '<th align="left">'
    puts tab * 4 + "<h6>#{$1.strip}</h6>"
    puts tab * 3 + "</th>"
    puts tab * 2 + "</tr>"
  elsif $_ =~ /^(\d+)(.*)/
    puts tab * 2 + "<tr>"
    puts tab * 3 + "<td valign=\"top\" width=\"10px\">#{$1}</td>"
    puts tab * 3 + "<td>"
    if $_.count(".") > 1
      puts tab * 4 + "<b>#{$2}</b><br>"
      puts tab * 4 + gets
    else
      puts  $2
    end
    puts tab * 3 + "</td>"
    puts tab * 2 + "</tr>"
  elsif $_ == "\n"
    puts  tab * 1 + "</tr>\n#{tab * 1}<tr>"
  else
  end
end
puts  "</tr>"