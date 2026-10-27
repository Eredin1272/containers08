pipeline {
    agent {
        label 'php-agent'
    }

    stages {
        stage('Install Dependencies') {
            steps {
                echo ' Подготовка проекта...'
                sh '''
                    php --version
                    mkdir -p build
                    rm -f build/test.sqlite
                    sqlite3 -bail build/test.sqlite < sql/schema.sql
                '''
            }
        }

        stage('Test') {
            steps{
                echo 'Запуск тестов...'
                sh 'php tests/tests.php'
            }
        }
    }

    post {
        always {
            echo 'Конвейер завершен.'
        }
        success {
            echo 'Все этапы прошли успешно!'
        }
        failure {
            echo 'Обнаружены ошибки в конвейере.'
        }
    }
}