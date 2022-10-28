/**
 * Created by Emmanuel Ravrat on 04/09/2022.
 */
import {readdir} from 'fs/promises'
// import shell from 'shelljs'
import path from 'path'
import {fileURLToPath} from 'url'
//https://sebhastian.com/nodejs-fork/
import childProcess from 'child_process'


//chemin complet du présent fichier
const __filename = fileURLToPath(import.meta.url)
const __dirname = path.dirname(__filename)
// console.log(__dirname)
const trackFolderNameProject = 'trackadoc'
let spotFolderName

//Je remonte l'arborescence de façon à découvrir le nom du dossier qui contient le dossier "trackadoc". Ce dossier sera le dossier SPOT
const   r = async (path) => {
    let pathToParentFolder
    let arrayForPath =  path.split(`\\`)
    //on supprime le répertoire courant du chemin
    let currentFolder = arrayForPath.pop()
    pathToParentFolder = arrayForPath.join('\\')
    //on récupère le nom du dossier parent
    let parentNameFolder = arrayForPath.pop()
    
    const files = await readdir(path, {withFileTypes: true});
    files.forEach((dirent) => {
        if(dirent.isDirectory() && dirent.name === trackFolderNameProject){
            spotFolderName = currentFolder
            return
        }
    })

    if(spotFolderName === undefined && parentNameFolder !== undefined){
        await r(pathToParentFolder)
    }
}

try {
     await r(__dirname)

} catch (err) {
    console.error(err);
}


// const regex = /([A-Za-z]{1}):\\SPOT/
const regex = new RegExp(`(.*)\\\\${spotFolderName}`)
// console.log(regex)
let found = __dirname.match(regex)
// console.log(`found ${found}`)

let pathToBootmainFile = `${found[0]}/${trackFolderNameProject}/bootmain.js`


const child = childProcess.fork(pathToBootmainFile, [__dirname])

child.on("close", function (code) {
    // console.log("child process exited with code " + code);
    process.exit(code)
});