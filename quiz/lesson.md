------------------------------------------------------------
**Creating a time-limited quiz**
------------------------------------------------------------
1. set up your MySQL database to store the quiz questions and user responses
    ```mysql
      -- Table to store quiz questions
      CREATE TABLE questions (
          id INT AUTO_INCREMENT PRIMARY KEY,
          question TEXT NOT NULL,
          option1 VARCHAR(255) NOT NULL,
          option2 VARCHAR(255) NOT NULL,
          option3 VARCHAR(255) NOT NULL,
          option4 VARCHAR(255) NOT NULL,
          correct_option TINYINT NOT NULL
      );
      -- Table to store user responses
      CREATE TABLE responses (
          id INT AUTO_INCREMENT PRIMARY KEY,
          user_id INT NOT NULL,
          question_id INT NOT NULL,
          selected_option TINYINT NOT NULL,
          is_correct BOOLEAN,
          response_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
      );

2. Inserting Sample Questions into the Database
    ```mysql
      INSERT INTO questions (question, option1, option2, option3, option4, correct_option) VALUES
      ("What is the capital of France?", "Berlin", "Madrid", "Paris", "Rome", 3),
      ("Which planet is known as the Red Planet?", "Earth", "Mars", "Jupiter", "Venus", 2),
      ("What is the largest mammal?", "Elephant", "Blue Whale", "Giraffe", "Hippopotamus", 2),
      ("Who wrote 'Romeo and Juliet'?", "William Shakespeare", "Charles Dickens", "Mark Twain", "Jane Austen", 1),
      ("What is the smallest prime number?", "0", "1", "2", "3", 3);

3. Create PHP scripts to fetch the quiz questions
    ```php
      include '../../function.php';
      $db = dbConn();
      $sql = "SELECT id, question, option1, option2, option3, option4 FROM questions";
      $result = $db->query($sql);
      
      $questions = array();
      if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
              $questions[] = $row;
          }
      }
      
      echo json_encode($questions);
4. Create PHP scripts to handle user responses
    ```php
      session_start();
      include '../../function.php';
      $db = dbConn();
      $user_id = $_SESSION['USERID'];
      
      extract($_POST);
      
      $sql = "SELECT correct_option FROM questions WHERE id = $question_id";
      $result = $db->query($sql);
      $row = $result->fetch_assoc();
      $is_correct = ($row['correct_option'] == $selected_option) ? 1 : 0;
      
      $sql = "INSERT INTO responses (user_id, question_id, selected_option, is_correct) VALUES ('$user_id', '$question_id', '$selected_option', '$is_correct')";
      $db->query($sql);
5. Frontend Logic with jQuery and AJAX
    ```html
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Time Limited Quiz</title>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            let questions = [];
            let currentQuestion = 0;        
            let timeLimit = 300; // 5 minutes in seconds
    
            function fetchQuestions() {
                $.ajax({
                    url: 'fetch_questions.php',
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        questions = data;
                        displayQuestion();
                        startTimer();
                    }
                });
            }
    
            function displayQuestion() {
                if (currentQuestion >= questions.length) {
                    alert("Quiz completed!");
                    return;
                }
                let q = questions[currentQuestion];
                $('#question').text(q.question);
                $('#option1').text(q.option1);
                $('#option2').text(q.option2);
                $('#option3').text(q.option3);
                $('#option4').text(q.option4);
            }
    
            function submitResponse(selectedOption) {
                let q = questions[currentQuestion];
                $.ajax({
                    url: 'submit_response.php',
                    method: 'POST',
                    data: {                   
                        question_id: q.id,
                        selected_option: selectedOption
                    },
                    success: function(response) {
                        alert(response);
                        currentQuestion++;
                        displayQuestion();
                    }
                });
            }
    
            function startTimer() {
                let timer = setInterval(() => {
                    if (timeLimit <= 0) {
                        clearInterval(timer);
                        alert("Time's up!");
                        return;
                    }
                    $('#timer').text(`Time left: ${timeLimit} seconds`);
                    timeLimit--;
                }, 1000);
            }
    
            $(document).ready(function() {
                fetchQuestions();
            });
        </script>
    </head>
    <body>
        <h1>Time Limited Quiz</h1>
        <div id="quiz">
            <div id="question"></div>
            <button onclick="submitResponse(1)" id="option1"></button>
            <button onclick="submitResponse(2)" id="option2"></button>
            <button onclick="submitResponse(3)" id="option3"></button>
            <button onclick="submitResponse(4)" id="option4"></button>
        </div>
        <div id="timer"></div>
    </body>
    </html>

    
6. Create a PHP script to fetch the quiz results
    ```php
      session_start();
      include '../../function.php';
      $db = dbConn();
      $user_id = $_SESSION['USERID'];
      
      
      $sql = "SELECT q.question, q.option1, q.option2, q.option3, q.option4, q.correct_option, r.selected_option, r.is_correct
              FROM questions q
              JOIN responses r ON q.id = r.question_id
              WHERE r.user_id = $user_id";
      $result = $db->query($sql);
      
      $results = array();
      if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
              $results[] = $row;
          }
      }
      
      echo json_encode($results);
7. Create a php file to display the results
    ```html
      <!DOCTYPE html>
      <html lang="en">
      <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Quiz Results</title>
          <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
          <script>
              
      
              function fetchResults() {
                  $.ajax({
                      url: 'fetch_results.php',
                      method: 'GET',
                      data: '',
                      dataType: 'json',
                      success: function(data) {
                          displayResults(data);
                      }
                  });
              }
      
              function displayResults(results) {
                  let totalQuestions = results.length;
                  let correctAnswers = results.filter(result => result.is_correct).length;
                  let html = `<h2>Your Score: ${correctAnswers} / ${totalQuestions}</h2>`;
      
                  results.forEach(result => {
                      html += `
                          <div class="question">
                              <p>${result.question}</p>
                              <ul>
                                  <li class="${result.correct_option == 1 ? 'correct' : ''} ${result.selected_option == 1 ? 'selected' : ''}">${result.option1}</li>
                                  <li class="${result.correct_option == 2 ? 'correct' : ''} ${result.selected_option == 2 ? 'selected' : ''}">${result.option2}</li>
                                  <li class="${result.correct_option == 3 ? 'correct' : ''} ${result.selected_option == 3 ? 'selected' : ''}">${result.option3}</li>
                                  <li class="${result.correct_option == 4 ? 'correct' : ''} ${result.selected_option == 4 ? 'selected' : ''}">${result.option4}</li>
                              </ul>
                          </div>
                      `;
                  });
      
                  $('#results').html(html);
              }
      
              $(document).ready(function() {
                  fetchResults();
              });
          </script>
          <style>
              .correct {
                  color: green;
              }
              .selected {
                  font-weight: bold;
              }
          </style>
      </head>
      <body>
          <h1>Quiz Results</h1>
          <div id="results"></div>
      </body>
      </html>

8. Redirect to Results Page After Quiz Completion
    ```html
      <!DOCTYPE html>
      <html lang="en">
          <head>
              <meta charset="UTF-8">
              <meta name="viewport" content="width=device-width, initial-scale=1.0">
              <title>Time Limited Quiz</title>
              <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
              <script>
                  let questions = [];
                  let currentQuestion = 0;
                  let timeLimit = 30; // 5 minutes in seconds
      
                  function fetchQuestions() {
                      $.ajax({
                          url: 'fetch_questions.php',
                          method: 'GET',
                          dataType: 'json',
                          success: function (data) {
                              questions = data;
                              displayQuestion();
                              startTimer();
                          }
                      });
                  }
      
                  function displayQuestion() {
                      if (currentQuestion >= questions.length) {
                          alert("Quiz completed!");
                          window.location.href = 'results.php';
                          return;
                      }
                      let q = questions[currentQuestion];
                      $('#question').text(q.question);
                      $('#option1').text(q.option1);
                      $('#option2').text(q.option2);
                      $('#option3').text(q.option3);
                      $('#option4').text(q.option4);
                  }
      
                  function submitResponse(selectedOption) {
                      let q = questions[currentQuestion];
                      $.ajax({
                          url: 'submit_response.php',
                          method: 'POST',
                          data: {
                              question_id: q.id,
                              selected_option: selectedOption
                          },
                          success: function (response) {
      
                              currentQuestion++;
                              displayQuestion();
                          }
                      });
                  }
      
                  function startTimer() {
                      let timer = setInterval(() => {
                          if (timeLimit <= 0) {
                              clearInterval(timer);
                              alert("Time's up!");
                              window.location.href = 'results.php';
                              return;
                          }
                          $('#timer').text(`Time left: ${timeLimit} seconds`);
                          timeLimit--;
                      }, 1000);
                  }
      
                  $(document).ready(function () {
                      fetchQuestions();
                  });
              </script>
          </head>
          <body>
              <h1>Time Limited Quiz</h1>
              <div id="quiz">
                  <div id="question"></div>
                  <button onclick="submitResponse(1)" id="option1"></button>
                  <button onclick="submitResponse(2)" id="option2"></button>
                  <button onclick="submitResponse(3)" id="option3"></button>
                  <button onclick="submitResponse(4)" id="option4"></button>
              </div>
              <div id="timer"></div>
          </body>
      </html>
 
10. 
