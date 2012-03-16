// The main-class for bringing the whole
// application to life thru one method

// Includes all the importen libs (in qt)
// that we need to use for this class to work
#include <QtGui/QApplication>
#include "mainwindow.h";

// Bringing the mainwindow to life - just by showing it!
int main(int argc, char *argv[])
{
    QApplication a(argc, argv);
    MainWindow w;
    w.show();
    
    return a.exec();
}
