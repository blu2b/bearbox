// very basic setup to clock in and out from shiftbase

// set email and password
let loginData = {
    "email": "$EXAMPLE@MAIL.COM",
    "password": "$SUPERSECRETPASSWORD"
  }

  // -----------------------------------------------
  // --------------- DO NOT TOUCH (: ---------------
  // -----------------------------------------------

  // generic post request
  async function PostCall(url, data, userToken = '') {
    const response = await fetch(url, {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
            'Content-Type': 'application/json',
            'Authorization': ('USER ' + userToken).trim()
        }
    })

    //console.log('Status code: ' + response.status + ' (' + url + ')')
    console.log(`Status code: ${response.status} ${response.statusText} (${url})`)
    if (!response.ok) {
        return response.json().then(response => console.log(response.meta.status_message))
    }
    return response.json()
  }

  // toggle clock endpoint
  async function ToggleClock() {
    const baseUrl = 'https://api.shiftbase.com/api'
    let userToken = ''
    let data = {
        // login
        userId: '',
        departmentId: '',
        action: "CLOCK_IN",
        authorization_level: "APPLICATION"
      }

    // login
    let loginResponse = await PostCall(baseUrl + '/users/login', loginData)
    userToken = loginResponse.data.token
    data.userId = loginResponse.data.User.Id
    data.departmentId = loginResponse.data.Department

    // toggle clock
    let clockToggleResponse = await PostCall(baseUrl + '/timesheets/clock', data, userToken)
  }

  // execute code
  ToggleClock();
