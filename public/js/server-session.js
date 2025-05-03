class ServerSession {

    #baseApiUrl = '/session';

    constructor(baseApiUrl) {
        this.#baseApiUrl = baseApiUrl;
        $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }

    retrieve(data, callback) {
        const context = this
        $.ajax({
            type: "POST",
            url: this.#baseApiUrl + "/retrieve",
            data: data,
            success: (data) => {
                if ("function" == typeof callback) {
                    callback.call(context, data)
                }
            },
            dataType: "json",
        })
    }

    store(data, callback) {
        const context = this
        $.ajax({
            type: "POST",
            url: this.#baseApiUrl + "/store",
            data: data,
            success: (data) => {
                if ("function" == typeof callback) {
                    callback.call(context, data)
                }
            },
            dataType: "json",
        })
    }
}
