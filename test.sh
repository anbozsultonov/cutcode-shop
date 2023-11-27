if[-n "$id"]; then
    echo $id

    echo $pullRequestId


    url="https://github.com/alifcapital/crm.backend/pull/${id}"

    echo $url

    author=$(git log -1 | grep Author)

    echo $author

    chatId=-614814904

    bot=bot5719761998:AAFcnNOlg0P5lU0FvVBd-qVgO-NgzcqXKsk


    telegram="https://api.telegram.org/${bot}/sendMessage"


    # curl -XPOST "${telegram}&text=test1"


    json="{\"chat_id\":\"${chatId}\",\"text\":\"${author}\", \"reply_markup\": { \"inline_keyboard\": [[{\"text\": \"Link\", \"url\": \"${url}\"}]]}}"



    #jsonToStr=$(echo $json  | jq -R)


    jsonToStr=$(echo  "'$json'")


    echo $jsonToStr

    curl -d "\
            {
                    \"chat_id\":\"${chatId}\",
                    \"text\":\"${author}\",
                    \"reply_markup\":
                            {
                                    \"inline_keyboard\":
                                            [
                                                    [
                                                            {
                                                                    \"text\": \"Link\",
                                                                    \"url\": \"${url}\"
                                                            }
                                                    ]
                                            ]
                            }
            }" -H "Content-Type: application/json" -X POST ${telegram}
fi

